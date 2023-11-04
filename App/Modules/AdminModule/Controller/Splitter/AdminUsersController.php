<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

use App\Core\DI\DIContainer;
use App\Core\Lib\Uploader;
use App\Modules\AdminModule\Controller\AdminController;
use App\Modules\AdminModule\Model\AdminUsers;
use App\Core\Lib\Utils\StringUtils;
use App\Model\AuthManager;
use App\Middleware\Auth;
use \App\Core\Lib\FormValidator;
use \App\Core\Application\Redirect;
use App\Core\Lib\Utils\MediaUtils;
use App\Exception\LoraException;
use App\Core\Lib\EmailSender;
//Module Model  


class AdminUsersController extends AdminController
{
    use FormValidator;
    
    /**
     * @var array <p>Injected classes to controller</p>
     */
    //protected $container;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;
    

    
    public function __construct(DIContainer $container, $model)
    {
        parent::__construct($container);
        
        $this->module = "admin";
        $this->model = $model;
    }
    
    
    public function index(AdminUsers $users, StringUtils $string_utils, MediaUtils $media) 
    {
        $get_all_users = $users->getAllUsers();
        $this->data = [
            "users" => $get_all_users,
            "password" => $string_utils->genarateHashedString(20, true),
        ];
        
        return $this->view = "users/index";
    }
    
    public function show(AdminUsers $user, MediaUtils $media)
    {
        $uid = $this->u["param"];
        $get_user_data = $user->getUser($uid);

        $this->data = [
            "user" => $get_user_data,
        ];

        
        

        return $this->view = "users/show";
    }
    
    public function createUser(AdminUsers $users, AuthManager $manager, Redirect $redirect, LoraException $exception)
    {
        $post = $this->input("user-name", "required,maxchars64", "User name")
            ->input("user-real-name", "required,maxchars64")
            ->input("user-surname", "required,maxchars64")
            ->input("user-email", "required,maxchars64,email")
            ->input("user-password", "required,maxchars128")
            ->returnFields();
        
        try {
            $manager->register($post["user-name"], $post["user-email"], "man", $post["user-password"], $post["user-password"], DATE("Y")+1, $post["user-real-name"], $post["user-surname"]);
            $exception->successMessage("User created successfully");
            $redirect->to("admin/app/users");
        } catch (LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }

        
        
    }
    
    public function userVerify(AdminUsers $users, LoraException $exception, Redirect $redirect)
    {
        $user_uid = $this->u["param"];
        
        try {
            $users->verifyUser($user_uid);
            $exception->successMessage("Uživatel byl ověřen!");
        } catch (LoraException $ex) {
            $exception->errorMessage("Uživatel nebyl ověřěn! Zkontrolujte prosím LOG");
        }
        $redirect->to("admin/app/users");
    }

    public function userPasswordForceReset(AdminUsers $users, LoraException $exception, Redirect $redirect)
    {
        $post = $this->input("password", "required,maxchars128")
                        ->input("uid", "required,url")
                        ->returnFields();

        try {
            $this->validate();
            $users->forcePasswordReset($post["uid"], $post["password"]);

            $exception->successMessage("Heslo bylo změněno!");
        }
        catch (LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
        }
        $redirect->to("admin/app/user-show/".$post["uid"]);
       
    }

    public function userAdminGrant(AdminUsers $users, LoraException $exception, Redirect $redirect)
    {
        $uid = $this->u["param"];
        try {
            $users->grantAdmin($uid);
            $exception->successMessage("Uživatel byl povýšen na admina!");
        }catch(LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
        }
    }

    public function userAdminRemove(AdminUsers $users, LoraException $exception, Redirect $redirect)
    {
        $uid = $this->u["param"];
        try {
            $users->removeAdmin($uid);
            $exception->successMessage("Uživatel byl odebrán z admin grantu!");
        }catch(LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
        }
    }

    public function userPasswordReset(AdminUsers $users, StringUtils $string_utils, LoraException $exception, Redirect $redirect, EmailSender $sender)
    {
        $uid = $this->u["param"];
        $user_data = $users->getUser($uid);
        $user_email = $user_data["email"];

        try {
            $recover_code = $users->sendRecoverPasswordCode($uid, $string_utils);
            $sender->send($user_email, "Reset hesla", "message_req_reset_password", [
                "{email_full}" => $user_email,
                "{user}" => $user_data["name"],
                "{web_name}" => env("web_name", false),
                "{web_url}" => env("web_url", false),
                "{recover_code}" => urlencode($recover_code),
                "{email}" => urlencode(str_replace('.', '%2E', $user_email)),
            ]);

            $exception->successMessage("Reset hesla proběhl úspěšně!");
        }catch(LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
        }
        $redirect->to("admin/app/users");
    }


    public function userRemove(AdminUsers $users, EmailSender $sender, LoraException $exception, Redirect $redirect)
    {
        $uid = $this->u["param"];
        $user_data = $users->getUser($uid);
        $user_email = $user_data["email"];

        try {
            $sender->send($user_email, "Odebrání uživatele", "message_deleted_account_by_system", [
                "{user}" => $user_data["name"],
                "{web_name}" => env("web_name", false),
            ]);
            $users->deleteUser($uid);

            $exception->successMessage("Uživatel byl odebrán!");
        }catch(LoraException $ex) {
            $exception->errorMessage($ex->getMessage());
        }
        $redirect->to("admin/app/users");
    
        
    }
    public function userChangeProfileImage(MediaUtils $media, LoraException $lora_exception, Redirect $redirect)
    {
        $uid = $this->u["param"];
        try {
            $media->uploadOneImage("public/img/avatar", "avatar", $uid);

            //resize image
            $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/512", $uid, target_width: "512", target_height: null);
            $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/256", $uid, target_width: "256", target_height: null);
            $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/128", $uid, target_width: "128", target_height: null);
            $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/64", $uid, target_width: "64", target_height: null);
            $media->resizeImage("public/img/avatar/$uid.png", "public/img/avatar/32", $uid, target_width: "32", target_height: null);

            unlink("public/img/avatar/$uid.png");
            $lora_exception->successMessage("Avatar byl úspěšně změněn!");
        }catch (LoraException $ex) {
            $lora_exception->errorMessage($ex->getMessage());
        }
        $redirect->to("admin/app/user-show/$uid");
    }

    public function userLog()
    {
        return $this->view = "users/log";
    }
}

