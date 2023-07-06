<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

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
    

    
    public function __construct($container, $model)
    {
        parent::__construct($container);
        
        $this->module = "admin";
        $this->container = $container;
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

        echo $user->is_admin;
        $this->data = [
            "user" => $get_user_data,
        ];

        
        

        return $this->view = "users/show";
    }
    
    public function createUser(AdminUsers $users, AuthManager $manager)
    {
        $post = $this->input("user-name", "required,maxchars64", "User name")
            ->input("user-real-name", "required,maxchars64")
            ->input("user-surname", "required,maxchars64")
            ->input("user-email", "required,maxchars64,email")
            ->input("user-password", "required,maxchars128")
            ->returnFields();
        
        try {
            $manager->register($post["user-name"], $post["user-email"], "man", $post["user-password"], $post["user-password"], DATE("Y")+1);
        } catch (LoraException $ex) {

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

    public function userUpdate(AdminUsers $users, LoraException $exception)
    {
        
    }

    public function userDelete(AdminUsers $users, LoraException $exception)
    {
        
    }

    public function userAdminSwitcher(AdminUsers $users, LoraException $exception)
    {

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
}

