<?php
//Changed -> add function get name from uid

namespace App\Middleware;

use App\Core\Application\Redirect;
use App\Core\Database\DB;
use App\Exception\LoraException;
use App\Core\Application\DotEnv;

/**
 * Description of Auth
 *
 * @author michaelmik
 */
class Auth
{    
    public $session_instance = "Lora22";
    protected $database;
    protected $exception;
    public $user_name = "";
    public $user_uid = 222222222;
    public $user_raw_id = -1;
    public $user_email = "";
    public $user_status = 0;
    public $user_color = "";
    public $user_text_color = "";
    public $host_uid = "143838695";
    public $role_module;
    public $is_logged;
    public $role = [];
    public $is_admin = false;

    protected DotEnv $env;
    
    private string $user_table = "users";
    
    
    private static $_instance = null;
    private static $_instance_id;

    public static function instance()
    {

        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }
        
        return self::$_instance;
        
    }

    public function __construct() 
    {
        $this->env = new DotEnv(".env");

        $this->database = DB::instance(db_driver: $_ENV["db_driver"], db_name: $_ENV["db_name"], is_factory: true);

        $this->exception = new LoraException();

        $env = parse_ini_file("./config/web.ini");
        $session_instance = $env["WEB_SESSION_STORE_NAME"];

        $this->session_instance = $session_instance;
        
        if(@$_SESSION[$this->session_instance]["user"] != "")
        {
            $this->user_name = @$_SESSION[$this->session_instance]["user"];
        }
        
        if(@$_SESSION[$this->session_instance]["uid"] != "")
        {
            $this->user_uid = @$_SESSION[$this->session_instance]["uid"];
        }
        
        if(@$_SESSION[$this->session_instance]["raw_id"] != "")
        {
            $this->user_raw_id = @$_SESSION[$this->session_instance]["raw_id"];
        }
        
        if(@$_SESSION[$this->session_instance]["raw_id"] != "")
        {
            $this->user_status = @$_SESSION[$this->session_instance]["user_status"];
        }
        
        if(@$_SESSION[$this->session_instance]["user_email"] != "")
        {
            $this->user_email = @$_SESSION[$this->session_instance]["user_email"];
        }
        
        if(@$_SESSION[$this->session_instance]["user_color"] != "")
        {
            $this->user_color = @$_SESSION[$this->session_instance]["user_color"];
        }
        
        if(@$_SESSION[$this->session_instance]["user_text_color"] != "")
        {
            $this->user_text_color = @$_SESSION[$this->session_instance]["user_text_color"];
        }

        
        $this->userGetRoles();
        $this->isMemberLogged();
        
        $this->is_admin = $this->checkAccess(["admin"]);
    }
    
    /**
     * For whole page -> if no authorized -> redirect to $callback
     * 
     * @param array $role_slug          <p>Array of required roles - slugs</p>
     * @param string|void $callback <p>(default: header("location: /homepage");) -> if string: header("location: $callback") else: call function </p>
     * @return mixed
     */
    public function access($role_slug = [], $callback = null)
    { 
        if(!$this->checkAccess($role_slug))
        {            
            if($callback != null)
            {
                if(gettype($callback) == "string")
                {
                    header("location: /".$callback);
                }
                else
                {
                    call_user_func($callback); 
                }
                
            }
            else
            {

                //Redirect::previous();
                //header("location: /");
            }          
        }
    }
    
    /**
     * return only true|false -> if user has access
     * 
     * @param array $role_slug
     * @return boolean
     */
    public function isAuth(array $role_slug = []): Bool
    {
        if($this->checkAccess($role_slug) == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function isLogged()
    {
        if($this->hasActiveSession() == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 
     * @param int $uid <p>Set UID of required user</p>
     * @return string <p>Returns user's name or Unknown</p>
     */
    public function getAuthor($uid = -1)
    {
        $db_query = $this->database->selectRow($this->user_table, "uid=?", [$uid]);
        
        if(!empty($db_query))
        {
            return $db_query["name"];
        }
        else
        {
            return "Unknown";
        }
    }
    
    
    /**
     * 
     * @param string $user_name
     * @return Int
     */
    public function getUserUID(string $user_name): Int
    {
        $db_query = $this->database->selectRow("user", "name=?", [$user_name]);
        if(!empty($db_query))
        {
            return intval($db_query["uid"]);
        }
        else
        {
            return 0;
        }
    }
    
    /**
     * 
     * @param string $table <p>checked table</p>
     * @param string|int $key   <p>Key for specific column (ex.: post_url = $param)
     * @param string|int $param <p>Specific param </p>
     * @param string $column <p>Checked column (def.: author)</p>
     * @return boolean
     */
    public function validateAuthor(string $table, $key, $param, string $column = "author"): Bool
    {
        if(isset($_SESSION[$this->session_instance]))
        {
            $uid = $_SESSION[$this->session_instance]["uid"];
            $db_query = $this->database->selectRow($table, $column."=? AND $key=?", [$uid, $param]);
            if(!empty($db_query))
            {
                return true;
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
    
    public function isAuthor($post_author_uid = 0)
    {
        if($post_author_uid == @$_SESSION[$this->session_instance]["uid"])
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function isVerified()
    {
        return true;
    }
    
    public function userGetRoles()
    {
        //store to session_array -> send to template, where function is in_array => for compiler

        $uid = $this->user_uid;
        
        $db_query = $this->database->select("role-id", "user_uid=?", [$uid]);
        
        foreach ($db_query as $row)
        {
            $role_slug = $row["role_slug"];
            $this->role[] = $role_slug;
        }
        
        if(in_array("admin", $this->role))  //if select where admin = 1 = all roles puts in array
        {            
            $db_all_roles = $this->database->select("roles", "id!=?", [0]);
            
            
            foreach ($db_all_roles as $role)
            {
                $this->role[] = $role["slug"];
            }
        }
        
        //else put only valid roles
    }
    
    /**
     * if false -> redirect to homepage
     * 
     * @param array $role_slug [required slug's names]
     * @param string $redirect [optional redirect callback]
     * @throws LoraException
     * 
     * 
     */
    private function checkAccess($role_slug = [])
    {
        //check if user is active
        if($this->hasActiveSession())
        {
            $get_user_uid = $_SESSION[$this->session_instance]["uid"];
            $return_boolean = [];
            
            foreach($role_slug as $slug)
            {
                
                $query = $this->database->selectRow("role-id", "user_uid=? AND role_slug=?", [$get_user_uid, $slug]);
                if(!empty($query))
                {
                    $return_boolean[] = "true";
                }
                else
                {
                    $return_boolean[] = "false";
                }
            }
            
            if(!in_array("true", $return_boolean))
            {
                //throw new LoraException("Nemáte povolení k akci!");
                return false;
            }
            else 
            {
                return true;
            }
        }
        else
        {
            //throw new LoraException("Nemáte povolení k akci! Musíte být přihlášen!");            
            return false;
        }
        
        //check if is in roles table
    }
    
    private function hasActiveSession()
    {
        if(isset($_SESSION[$this->session_instance]["user"]) && $_SESSION[$this->session_instance]["uid"] != "")
        {
            return true;
        }
        else
        {
            return false;
        } 
        return true;
    }
    
    private function isMemberLogged()
    {
        if($this->hasActiveSession() == true)
        {
            $this->is_logged = true;
        }
        else
        {
            $this->is_logged = false;
        }
    }
    
}
