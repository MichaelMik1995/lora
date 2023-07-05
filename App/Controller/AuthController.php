<?php
declare (strict_types=1);

namespace App\Controller;

use App\Model\AuthManager;
use App\Exception\LoraException;
use App\Middleware\Session;
use App\Middleware\Auth;
use App\Core\Lib\FormValidator;
use App\Core\Application\Redirect;

class AuthController extends Controller
{
    use FormValidator;

    public $container;
    
    public function __construct($container) 
    {
        parent::__construct($container);
        $this->container = $container;
    }
    
    /**
     * Login form for login user to web application (auth/login)
     *
     * @param Auth $auth
     * @param Redirect $redirect
     * @return void
     */
    public function login(Auth $auth, Redirect $redirect)
    {
        if($auth->isLogged() == true)
        {
            $redirect->to("homepage");
        }
        $this->title = lang("title_login", false);
    }
    
    /**
     * Function to validate the login form and login the user
     *
     * @param AuthManager $auth_manager
     * @param Redirect $redirect
     * @param Session $session
     * @param LoraException $lora_exception
     * @return void
     */
    public function doLogin(AuthManager $auth_manager, Redirect $redirect, Session $session, LoraException $lora_exception)
    {        
        $post = $this->input("name", "required,string")->input("password", "required,string")->returnFields();
        try
        {
            $this->validate();

            $auth_manager->login($post["name"], $post["password"]);
            $lora_exception->successMessage("Přihlášení proběhlo úspěšně!");
            $session->generateSID(1);
            
            $redirect->to("");

        } catch (LoraException $ex) 
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->to("auth/login");
        }

    }
    
    /**
     * Register form for registration (auth/register)
     *
     * @return void
     */
    public function register()
    {
        $this->title = lang("title_register", false);
    }
    
    /**
     * After submiting the registration form, this method will be called and the user will be registered (if form is corectly submitted)
     *
     * @param AuthManager $auth_manager
     * @param Redirect $redirect
     * @param Session $session
     * @param LoraException $lora_exception
     * @return void
     */
    public function doRegister(AuthManager $auth_manager, Redirect $redirect, Session $session, LoraException $lora_exception)
    {
        
        $post = $this->input("name", "required,string", lang("register_name_field", false))
                ->input("email", "required,email", lang("register_email_field", false))
                ->input("gender", "required,string", lang("register_gender_field", false))
                ->input("password1", "required,string", lang("register_password1_field", false))
                ->input("password2", "required,string", lang("register_password2_field", false))
                ->input("antispam", "required,antispam,not0", lang("register_antispam_field", false))
                ->input("confirmed", "required,confirmed", lang("register_confirm_field", false))
                ->returnFields();

            try
            {
                $this->validate();
                $this->passwordConfirm($post["password1"], $post["password2"]);

                $auth_manager->register(
                    $post["name"], 
                    $post["email"], 
                    $post["gender"], 
                    $post["password1"], 
                    $post["password2"], 
                    $post["antispam"]
                );

                $lora_exception->successMessage(lang("succes_regsitration_message", false));
                $session->generateSID(1);
                $redirect->to("auth/register-success");
            } catch (LoraException $ex) 
            {
                $lora_exception->errorMessage($ex->getMessage());
            } 
    }

    /**
     * If registration is successful this page will be shown
     *
     * @return void
     */
    public function registerSuccess()
    {
        $this->title = lang("title_register_success", false);
    }

    /**
     * Registration rules (auth/register-rules)
     *
     * @return void
     */
    public function rules()
    {
        $this->data = [
            "web_name" => env("web_name", false),
        ];
        
        $this->title = lang("register_title_rules", false);
    }
    
    /**
     * Logout user (auth/logout)
     *
     * @param AuthManager $auth_manager
     * @param Redirect $redirect
     * @param LoraException $lora_exception
     * @return void
     */
    public function logout(AuthManager $auth_manager, Redirect $redirect, LoraException $lora_exception)
    {
        try 
        {
            $auth_manager->logout();
            $lora_exception->successMessage("Odhášení proběhlo úspěšně! Nashledanou");
            $redirect->previous();
        } catch (LoraException $ex) {
            $lora_exception->errorMessage($ex->getMessage());
        }
    }

    /**
     * This method calls after user clicked to button from email address
     *
     * @param AuthManager $auth_manager
     * @param Redirect $redirect
     * @param LoraException $lora_exception
     * @return void
     */
    public function verifyUser(AuthManager $auth_manager, Redirect $redirect, LoraException $lora_exception)
    {
        $user_verify_code = urldecode($this->u["code"]);
        $user_name = urldecode($this->u["name"]);

        try {
            $auth_manager->verify($user_verify_code, $user_name);
            $redirect->to("auth/verify-success");
        }
        catch (LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->to("auth/verify-error");
        }
    }

    /**
     * If verification code is success, this method is called
     *
     * @return void
     */
    public function verifySuccess()
    {
        $this->title = lang("title_verify_success", false);
        
    }

    /**
     * If verification code is wrong, this method is called
     *
     * @return void
     */
    public function verifyError()
    {
        $this->title = lang("title_verify_error", false);
    }
}
?>
