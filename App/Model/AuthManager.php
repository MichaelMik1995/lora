<?php
declare (strict_types=1);

namespace App\Model;

use App\Core\Model;
use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\EmailSender;
use App\Middleware\Session;
use App\Middleware\Auth;
use App\Core\Database\DB;
use App\Core\Application\DotEnv;
use App\Core\Lib\Uploader;
use App\Core\Lib\Utils\MediaUtils;

class AuthManager extends Model
{

    public Uploader $upload;
    public ?StringUtils $s_utils = null;
    
    protected $database;
    protected string $table = "users";
    
    
    protected $email;
    protected $env;
    
    private static $_instance;
    private static $_instance_id;
    
    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self;
            self::$_instance_id = rand(000000,999999);
        }
        
        return self::$_instance;
    }
    
    public function __construct($injected_classes = null)
    {
        
        $this->init();
        $this->env = new DotEnv();
        
        $this->database = DB::instance($_ENV["db_driver"], db_name: $_ENV["db_name"]);//$injected_classes["Database"];
       
        
        if($this->s_utils == null)
        {
            $this->s_utils = new StringUtils();
        }
        
        if($this->uploader == null)
        {
            $this->uploader = new Uploader();
        }
        
        $this->email = new EmailSender();
    }
    
    public function login(string $name, string $password)
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
            
            if(password_verify($password, $db_password))
            {         
                $_SESSION[$this->auth->session_instance]["user"] = $user_name;
                $_SESSION[$this->auth->session_instance]["uid"] = $uid;
                $_SESSION[$this->auth->session_instance]["user_email"] = $email;
                $_SESSION[$this->auth->session_instance]["raw_id"] = $raw_id;
                $_SESSION[$this->auth->session_instance]["status"] = 1;
                
                $session = new Session();
                $session->generateSID(1);
                $session->generateSJID(1);
                
                $this->database->update($this->table, ["last_login"=>time(), "status"=>1], "uid=?", [$uid]);
                if(isset($_COOKIE["cookies_accepted"]) && $_COOKIE["cookies_accepted"] == true)
                {
                    if(!isset($_COOKIE["session_key"]))
                    {
                        //30 DAYS = 60*60*24*30 = 2592000
                        $session_key = MD5(time().time()/2);
                        setcookie("session_key", $session_key, time() + 3600*24*10, "/");
                        echo "<script>localStorage.setItem('user_name','".$user_name."');</script>";
                        $this->database->update($this->table, ["session_key"=>$session_key], "uid=?", [$uid]);
                    }
                }
                return true;
            }
            else
            {
                throw new \App\Exception\LoraException("Zadané heslo není platné!");
            }
        }
        else 
        {
            throw new \App\Exception\LoraException("Tento uživatel zde není zaregistrován nebo nemá ověřený účet!");
        }
    }
    
    public function logout(): Bool
    {
        session_regenerate_id(true);
        $session = new Session();

        if(isset($_SESSION[$this->auth->session_instance]))
        {
            $this->database->update($this->table, ["status"=>0], "uid=?", [$_SESSION[$this->auth->session_instance]["uid"]]);
            unset($_SESSION[$this->auth->session_instance]);
        }

        $session->generateSID(1);
        $session->generateSJID(1);
        
        if(isset($_COOKIE["session_key"]))
        {
            unset($_COOKIE["session_key"]);
            setcookie('session_key', "", -1, '/'); 
        }

        echo "<script>localStorage.removeItem('user_name');</script>";
        return true;
    }
    
    public function register(string $name, string $email, string $gender, string $password, string $password_verify, string|int $antispam)
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
            $verify_code = $this->s_utils->genarateHashedString(10);
            
            
            
            $db_insert = $this->database->insert($this->table, [
                "uid" => $uid,
                "name" => $name,
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
                "{web_url}" => $this->config->var("WEB_ADDRESS"),
                "{verify_code}" => $verify_code,
                "{email}" => $email, 
            ]);
            
            return true;
        }
        else
        {
            throw new \App\Exception\LoraException("Toto jméno nebo email je již zaregistrované v systému!");
        }
    }
    
    public function verify(string $code, string $email)
    {
        $db_query = $this->database->selectRow($this->table, "verify_code=? AND email=? AND email_verified_at=? LIMIT 1", [$code, $email, 0]);
        if(!empty($db_query))
        {
            $this->database->update($this->table, ["email_verified_at"=>time()], "email=?", [$email]);
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
        if(isset($_SESSION[$this->auth->session_instance]))
        {
            $this->database->update($this->table, ["status"=>$status], "uid=?", [$_SESSION[$this->auth->session_instance]["uid"]]);
            $_SESSION[$this->auth->session_instance]["user_status"] = $status;
            $this->auth->user_status = $status;
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

        
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/512", $uid, target_width: "512", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/256", $uid, target_width: "256", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/128", $uid, target_width: "128", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/64", $uid, target_width: "64", target_height: null);
        $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/32", $uid, target_width: "32", target_height: null);
        
        unlink("public/img/avatar/$uid.png");
        
        return true;
    }
    public function removeUser($uid)
    {
        //Destroy image avatar
        @unlink("./public/img/avatar/$uid.png");

        //Destroy folders
        @unlink("./public/img/user/$uid/images/thumb");
        @unlink("./public/img/user/$uid/images");
        @unlink("./public/img/user/$uid");

        //Remove from roles
        $remove_roles = $this->database->delete("role-id", "user_uid=?", [$uid]);

        //Remove from users
        $remove_user = $this->database->delete($this->table, "uid=?", [$uid]);

        if($remove_roles && $remove_user)
        {
            return true;
        }
        else
        {
            throw new \Exception("Chyba při odstraňování uživatele!");
        }

    }
}
?>
