<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller;
use App\Modules\UserModule\Controller\Splitter\UserDashboardController;
use App\Modules\UserModule\Controller\Splitter\UserGalleryController;
use App\Modules\UserModule\Controller\Splitter\UserProfileController;


//Core
use App\Controller\Controller;
use App\Middleware\Auth;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Core\Application\Redirect;
use App\Core\DI\DIContainer;

//Interface
use App\Core\Interface\ModuleInterface;

//Module Model
use App\Modules\UserModule\Model\User;

//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;

/**
 *  Main controller for module User
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class UserController extends Controller implements ModuleInterface
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address ex.: (/user/show/:url) -> $u['url']</p>
     */
    public $u;
    
    /**
     * @instance of main model: User() of this controller.
     */
    protected $model;

    //Only DIContainer can be pass as argument in __construct()!
    public function __construct(DIContainer $container)     
    {
        parent::__construct($container, u: $this->u, model: $this->model);

        //Check, if user is logged
        if($this->container->get(Auth::class)->isLogged() === false)
        {
            $this->container->get(LoraException::class)->errorMessage("Nejste přihlášen/a! Prosím přihlašte se");
            $this->container->get(Redirect::class)->to('auth/login');
        }
    }
    
    /**
     *  Replaces old index() function for initiliazing module with splitters (IF MODULE IS NOT USE SPLITTERS, USE BASIC CRUD METHODS BELLOW!)
     *
     */
    public function initialize(Redirect $redirect) 
    {
        $this->title = 'User';

        if(isset($this->u["page"]))
        {
            $pages_dashboard = [
                "dashboard" => "dashboard"
            ];

            $gallery_pages = [
                "gallery" => "galleryIndex",
                "gallery-images-insert" => "imagesInsert",
                "gallery-picture-show" => "imageShow",
                "picture-update-alt" => "updateAltImage",
                "gallery-picture-delete" => "imageDelete",
            ];

            $profile_pages = [
                "user-profile" => "userProfile",
            ];

            $this->splitter(UserDashboardController::class, $pages_dashboard, "Přehled");
            $this->splitter(UserGalleryController::class, $gallery_pages, "Galerie");
            $this->splitter(UserProfileController::class, $profile_pages, "Profil");
        }
        else
        {
            $redirect->to("user/app/dashboard");
        }
        
    }
}

