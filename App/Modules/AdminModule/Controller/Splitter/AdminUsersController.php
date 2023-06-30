<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

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
    //protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;
    

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "admin";
        $this->injector = $injector;
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
    
    public function show(AdminUsers $users, MediaUtils $media)
    {
        $uid = $this->u["param"];
        $get_user_data = $users->getUser($uid);
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
    
    public function userVerify(AdminUsers $users, LoraException $exception)
    {
        $user_uid = $this->u["param"];
        
        try {
            $users->verifyUser($user_uid);
            $exception->successMessage("Uživatel byl ověřen!");
        } catch (LoraException $ex) {
            $exception->errorMessage("Uživatel nebyl ověřěn! Zkontrolujte prosím LOG");
        }
        @Redirect::redirect("admin/app/users");
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
}

