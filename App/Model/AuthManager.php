<?php
declare (strict_types=1);

namespace App\Model;

use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\EmailSender;
use App\Middleware\Session;
use App\Middleware\Auth;
use App\Core\Database\Database;
use App\Core\Application\DotEnv;
use App\Core\Lib\Uploader;
use App\Core\Lib\Utils\MediaUtils;
use App\Core\DI\DIContainer;
use App\Exception\LoraException;
use App\Core\Lib\Language;
use App\Core\Lib\Logger;


class AuthManager
{

    public ?Uploader $uploader;
    public ?StringUtils $s_utils = null;
    
    protected $database;
    protected string $table = "users";
    protected $logger;
    
    protected $email;
    protected $env;

    private $session;

    private DIContainer $container;
    
    public function __construct(DIContainer $container, Uploader $uploader, StringUtils $string_utils, EmailSender $email_sender, Logger $logger)
    {
        
        $this->container = $container;

        $this->env = $this->container->get(DotEnv::class);
        
        $this->database= $this->container->set(Database::class, [$_ENV["db_driver"], "", $_ENV["db_name"], "", "", false]);
       
        $this->s_utils = $string_utils;
    
        $this->uploader = $uploader;
        
        $this->email = $email_sender;
        
        $this->session = $this->container->get(Session::class);

        $this->logger = $logger;


        /* Check all files -> if eny greater than XXX -> pack and delete old */
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function checkAttempts(): Bool
    {
        /* 
            1. pokud není session -> vytvořit (attempts, checked time) $_SESSION['local_ip']['attempts'] = 0; $_SESSION['local_ip']['est_time'] = time()+10;

            * testovat pokusy o přihlášení -> pokud je fail, tak attempt + 1

            * Pokud dosáhne attemp na hodnotu 3 -> zablokovat na určitý čas
            
            Po určitém čase -> vynulovat attempt -> lze zadat nové pokusy o přihlášení
        */

        $local_ip = $_SERVER['REMOTE_ADDR'];

        //Create attempts array if it doesn't exist
        if(!isset($_SESSION[$local_ip]['attempts']))
        {
            $_SESSION[$local_ip]['attempts'] = 0;
            $_SESSION[$local_ip]['last_attempt'] = time();
        }

        return true;
    }

    public function login(string $name, string $password, $autologin = false)
    {
        session_regenerate_id(true);
        $db_query = $this->database->selectRow($this->table, "(name=? OR email=?) AND email_verified_at!=?", [$name, $name, 0]);
        if(!empty($db_query))
        {
            $raw_id = $db_query["id"]; //for rating post, comments etc ..
            $user_name = $db_query["name"];
            $uid = $db_query["uid"];
            $email = $db_query["email"];
            $email_verified = $db_query["email_verified_at"];
            $db_password = $db_query["password"];


                if((password_verify($password, $db_password) && $autologin == false) || $autologin == true)
                {         
                    
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["user"] = $user_name;
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["uid"] = $uid;
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["user_email"] = $email;
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["raw_id"] = $raw_id;
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["status"] = 1;
                    $_SESSION[$this->container->get(Auth::class)->session_instance]["hashed_uid"] = $this->s_utils->generateHashFromString($uid, md5($uid.$uid), 26);
                    
                    $this->session->generateSID(1);
                    $this->session->generateSJID(1);
                    
                    $this->database->update($this->table, ["last_login"=>time(), "status"=>1], "uid=?", [$uid]);
                    if(isset($_COOKIE["cookies_accepted"]) && $_COOKIE["cookies_accepted"] == "true")
                    {
                        if(!isset($_COOKIE["session_key"]))
                        {
                            //30 DAYS = 60*60*24*30 = 2592000
                            $session_key = MD5(time().time()/2);
                            setcookie("session_key", $session_key, time() + 3600*24*10, "/");
                            echo "<script>localStorage.setItem('user_name','".$user_name."');</script>";
                            $this->database->update($this->table, ["session_key"=>$session_key], "uid=?", [$uid]);
                            //LOG event
                            $this->logger->log("User ".$user_name." [uid].".$uid."[/uid]logged in with session key ".$session_key, log_file: "./private/logs/users/".$uid, can_create_new_log: true);
                            //unset attempt test session
                        }
                    }
                    return true;
                }
                else
                {
                    throw new LoraException("Zadané heslo není platné!");
                }
        }
        else 
        {
            throw new LoraException("Tento uživatel zde není zaregistrován nebo nemá ověřený účet!");
        }
    }

    /**
     * If autologin successfull -> return true
     */
    public function autoLogin(Auth $auth)
    {
        //Check if cookie already exists
        if(isset($_COOKIE["cookies_accepted"]) && $_COOKIE["cookies_accepted"] == "true" && isset($_COOKIE["session_key"]))
        {
            if($auth->isLogged() == false)
            {
                $user_by_session_key = $this->database->selectRow("users", "session_key=?", [$_COOKIE["session_key"]]);
                if(!empty($user_by_session_key))
                {
                    return $this->login($user_by_session_key["name"], $user_by_session_key["password"], true);
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }
    
    public function logout(): Bool
    {
        session_regenerate_id(true);
        $this->logger->log("User ".$this->container->get(Auth::class)->user_name." [uid].".$this->container->get(Auth::class)->user_uid."[/uid] logout from application", 
        log_file: "./private/logs/users/".$this->container->get(Auth::class)->user_uid, can_create_new_log: true);

        if(isset($_SESSION[$this->container->get(Auth::class)->session_instance]))
        {
            $this->database->update($this->table, ["status"=>0], "uid=?", [$_SESSION[$this->container->get(Auth::class)->session_instance]["uid"]]);
            unset($_SESSION[$this->container->get(Auth::class)->session_instance]);
        }

        $this->session->generateSID(1);
        $this->session->generateSJID(1);
        
        if(isset($_COOKIE["session_key"]))
        {
            unset($_COOKIE["session_key"]);
            setcookie('session_key', "", -1, '/'); 
        }

        echo "<script>localStorage.removeItem('user_name');</script>";
        return true;
    }
    
    public function register(string $name, string $email, string $gender, string $password, string $password_verify, string|int $antispam, string $real_name = "", string $surname = "")
    {
        //Form validated!
        
        //check if name not exists in db
        $check_name = $this->database->selectRow($this->table, "name=? OR email=?", [$name, $email]);
        if(empty($check_name) && $antispam == DATE("Y")+1)
        {
            $password_hash = $this->password_hash($password);
            $uid = rand(111111111, 999999999);
            $now = time();
            $col = "`uid`, `name`, `email`, `email_verified_at`, `password`, `registration_date`, `last_login`";
            $params = "'$uid', '$name', '$email', '0', '$password_hash', '$now', '$now'";
            $verify_code_raw = $this->s_utils->genarateHashedString(10);
            $verify_code = $this->s_utils->toSlug($verify_code_raw);
            
            
            $db_insert = $this->database->insert($this->table, [
                "uid" => $uid,
                "name" => $name,
                "real_name" => $real_name,
                "surname" => $surname,
                "email" => $email,
                "email_verified_at" => "0",
                "password" => $password_hash,
                "registration_date" => $now,
                "last_login" => "0",
                "verify_code" => $verify_code,
            ]);
            
            //create Avatars
            $this->createAvatars($gender, $uid);
            
            //send email for verify code
            $this->email->send($email, "Registrace nového člena", "message_register", [
                "{new_user}" => $name,
                "{web_name}" => $_ENV["web_name"],
                "{web_url}" => $_ENV["base_href"],
                "{verify_code}" => $verify_code,
                "{email}" => $name, 
            ]);
            
            return true;
        }
        else
        {
            throw new LoraException("Toto jméno nebo email je již zaregistrované v systému!");
        }
    }
    
    public function verify(string $code, string $name)
    {
        $db_query = $this->database->selectRow($this->table, "verify_code=? AND name=? AND email_verified_at=? LIMIT 1", [$code, $name, 0]);
        if(!empty($db_query))
        {
            $this->database->update($this->table, ["email_verified_at"=>time()], "name=?", [$name]);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function password_hash(string $password)
    {
        $psw = htmlentities($password);
        $options = [
        "cost" => 12,  
        ];
        
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        return $hash;
    }
    
    public function createUserId(): Int
    {
        return rand(00000000,99999999);
    }
    
    public function selectUser($session_key)
    {
        return $this->database->selectRow($this->table, "session_key=? AND email_verified_at!=?", [$session_key, 0]);
    }
    
    public function changeStatus($status): Bool
    {
        if(isset($_SESSION[$this->container->get(Auth::class)->session_instance]))
        {
            $this->database->update($this->table, ["status"=>$status], "uid=?", [$_SESSION[$this->container->get(Auth::class)->session_instance]["uid"]]);
            $_SESSION[$this->container->get(Auth::class)->session_instance]["user_status"] = $status;
            $this->container->get(Auth::class)->user_status = $status;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function createAvatars(string $gender, int $uid)
    {
        $media = MediaUtils::instance();
        //create folders for user
            mkdir("./public/img/user/$uid");
            mkdir("./public/img/user/$uid/images");
            mkdir("./public/img/user/$uid/images/thumb");
            
        //create avatar
        copy("./public/img/avatar/default_$gender.png", "./public/img/avatar/$uid.png");

        
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/512", strval($uid), target_width: "512", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/256", strval($uid), target_width: "256", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/128", strval($uid), target_width: "128", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/64", strval($uid), target_width: "64", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/32", strval($uid), target_width: "32", target_height: null);
        
        unlink("public/img/avatar/$uid.png");
        
        return true;
    }

    public function sendRecoverPasswordCode(string $email)
    {
        $new_key_hash = $this->s_utils->genarateHashedString(26);
        
        $slugged_string = $this->s_utils->toSlug($new_key_hash);
        $this->database->update($this->table, ["password_recover_key"=>$slugged_string], "email=?", [$email]);
        return $slugged_string;
    }

    /**
     * Check, if key exists in database with user email address (if is valid)
     *
     * @param string $key
     * @param string $email
     * @return bool
     */
    public function checkExistinRecoverKey(string $key, string $email): Bool
    {
        $db_query = $this->database->selectRow($this->table, "email=? AND password_recover_key=?", [$email, $key]);
        if(!empty($db_query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function recoverPassword(array $post)
    {
        extract($post);
        $db_query = $this->database->selectRow($this->table, "email=? AND password_recover_key=? AND name=?", [$email, $key, $name]);
        if(!empty($db_query))
        {
            $password_hash = $this->s_utils->generateHashedPassword($password1);
            return $this->database->update($this->table, ["password"=>$password_hash, "password_recover_key"=>null], "email=? AND name=?", [$email, $name]);
        }
        else
        {
            throw new LoraException($this->container->get(Language::class)->lang("recover_password_error"));
        }
    }
}
?>
