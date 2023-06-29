<?php
declare (strict_types=1);

namespace App\Controller;

use App\Model\AuthManager;
use App\Exception\LoraException;
use App\Middleware\Session;

class AuthController extends Controller 
{
    protected $auth;
    protected $validation;
    public $injector;
    protected $auth_manager;
    protected $session;
    public $title;
    
    public function __construct($injector) 
    {
        parent::__construct($this->title, $injector);
        $this->injector = $injector;
        $this->auth_manager = new AuthManager($injector);
        $this->session = new Session();
    }
    
    public function login(){}
    
    public function doLogin()
    {
        extract($this->injector);
        
        $exception = $loraexception;
        
        $validation->validate($_POST["name"], ["required","string"], "Jméno");
        $validation->validate($_POST["password"], ["required","string"], "Heslo");

        
        if($validation->isValidated() == true)
        {
            try
            {
                $this->auth_manager->login($_POST["name"], $_POST["password"]);
                $exception->successMessage("Přihlášení proběhlo úspěšně!");
                $this->session->generateSID(1);
                
                $this->redirect("");

            } catch (LoraException $ex) 
            {
                $exception->errorMessage($ex->getMessage());
                $this->redirect("auth/login");
            }
        }
        else
        {
            $this->redirect("auth/login");
        }
    }
    
    public function register(){}
    
    public function registerRules(){}
    
    public function doRegister()
    {
        extract($this->injector);
        
        $exception = $loraexception;
        
        $validation->validate($validation->input("name"), ["required","string"], "Jméno");
        $validation->validate($validation->input("email"), ["required", "email", "string"], "Email");
        $validation->validate($validation->input("gender"), ["required", "string"], "Pohlaví");
        $validation->passwordConfirm($validation->input("password1"), $validation->input("password2"));

        $validation->validate($validation->input("antispam"), ["required", "antispam", "not0", "int"]);
        $validation->validate($validation->input("confirmed"), ["required", "confirmed"], "Podmínky webu");

        if($validation->isValidated() == true)
        {
            try
            {
                $this->auth_manager->register(
                    $validation->input("name"), 
                    $validation->input("email"), 
                    $validation->input("gender"), 
                    $validation->input("password1"), 
                    $validation->input("password2"), 
                    $validation->input("antispam")
                );

                $exception->successMessage("Děkujeme za registraci! Na Váš EMAIL jsme poslali aktivační údaje!");
                $this->session->generateSID(1);
                $this->redirect("auth/login");
            } catch (LoraException $ex) 
            {
                $exception->errorMessage($ex->getMessage());
            } 
        }
    }
    
    public function logout()
    {
        try {
                $this->auth_manager->logout();
                $this->injector["LoraException"]->successMessage("Odhášení proběhlo úspěšně! Nashledanou");
                $this->previous();
                } catch (LoraException $ex) {

                }
    }
    
    /*public function index($url) 
    {
        $this->auth = $this->class["Auth"];                       // create instance for model
        $auth = $this->class["Auth"];                                                 // create instance for authenticate user
        $easy_text = $this->class["Easytext"];                                        // Read and translate block (like wysiwyg block system)
        $lora = $this->class["LoraException"];                              // For catching exceptions
        $validation = $this->class["Validation"];                                     // Create instance for validate fields from $_POST
        $auth_manager = new AuthManager($this->class);
        $session = new Session();
        
        
        $action = @$url[1];                                                 // $action [create|update|show ..] (/controller/ACTION/route_param)
        $route_param = @$url[2];                                            // for showing, editing, deleting row (/controller/action/ROUTE_PARAM)

        $view_folder = "auth/";
            
        switch($action)
        {
            case "register": //view register
                $this->view = "auth/register";
                break;
            
            case "do-register": //submiting register button
                
                $validation->validate($validation->input["name"], ["required","string"], "Jméno");
                $validation->validate($validation->input["email"], ["required", "email", "string"], "Email");
                $validation->validate($validation->input["gender"], ["required", "string"], "Pohlaví");
                $validation->passwordConfirm($validation->input["password1"], $validation->input["password2"]);
                
                $validation->validate($validation->input["antispam"], ["required", "antispam", "not0", "int"]);
                $validation->validate($validation->input["confirmed"], ["required", "confirmed"], "Podmínky webu");
               
                if($validation->isValidated() == true)
                {
                    try
                    {
                        $auth_manager->register(
                            $validation->input["name"], 
                            $validation->input["email"], 
                            $validation->input["gender"], 
                            $validation->input["password1"], 
                            $validation->input["password2"], 
                            $validation->input["antispam"]
                        );
                        
                        $lora->successMessage("Děkujeme za registraci! Na Váš EMAIL jsme poslali aktivační údaje!");
                        $session->generateSID(1);
                        $this->redirect("auth/login");
                    } catch (LoraException $ex) 
                    {
                        $lora->errorMessage($ex->getMessage());
                    } 
                }
                
                break;
                
            case "verify":
                $verify_code = urldecode($url[2]);
                $email = urldecode($url[3]);
                
                try{
                    $auth_manager->verify($verify_code, $email);
                    $this->redirect("auth/verify-success");
                    
                } catch (LoraException $ex) 
                {
                    $this->redirect("auth/verify-dead/$verify_code/$email");
                }
                break;
                
            case "verify-success":   
                $this->view = "auth/verify_success";
                break;
            
            case "verify-dead":   
               $this->data = [
                  "email" => urldecode($url[3]),
                    "code" => urldecode($url[2])
                ];
                
                $this->view = "auth/verify_dead";
                break;
                
            case "verify-resend":
                $verify_code = urldecode($url[2]);
                $email = urldecode($url[3]);
                break;
            
            case "login":    
                $this->header["title"] = "Přihlášení uživatele";
                $this->view = "auth/login";
                break;
            
            case "do-login":               
                
                $validation->redirect = "/user/register";
                $validation->validate($validation->input["name"], ["required","string"], "Jméno");
                $validation->validate($validation->input["password"], ["required","string"], "Heslo");
                
                if($validation->isValidated() == true)
                {
                    try
                    {
                        $auth_manager->login($validation->input["name"], $validation->input["password"]);
                        $lora->successMessage("Přihlášení proběhlo úspěšně!");
                        $session->generateSID(1);
                        $this->redirect("");
                        
                    } catch (LoraException $ex) 
                    {
                        $lora->errorMessage($ex->getMessage());
                        $this->redirect("auth/login");
                    }
                }
                else
                {
                    $this->redirect("auth/login");
                }
                
                break;
                
            case "logout":

                try {
                $auth_manager->logout();
                $lora->successMessage("Odhášení proběhlo úspěšně! Nashledanou");
                $this->redirect("");
                } catch (Exception $ex) {

                }
                
                break;
            
            case "change-status":
                $auth_manager->changeStatus($route_param);
                $this->redirect("community");
                break;
            
            case "rules":
                
                $this->view = "auth/rules";
                break;
        }
    }*/
}
?>
