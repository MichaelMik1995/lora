<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller;

//Core
use App\Controller\Controller;
use App\Core\Application\Redirect;

//Splitters
use App\Modules\AdminModule\Controller\Splitter\AdminDashboardController;
use App\Modules\AdminModule\Controller\Splitter\AdminBanController;
use App\Modules\AdminModule\Controller\Splitter\AdminCLIController;
use App\Modules\AdminModule\Controller\Splitter\AdminDatabaseController;
use App\Modules\AdminModule\Controller\Splitter\AdminLogController;
use App\Modules\AdminModule\Controller\Splitter\AdminMediaController;
use App\Modules\AdminModule\Controller\Splitter\AdminModulesController;
use App\Modules\AdminModule\Controller\Splitter\AdminPluginsController;
use App\Modules\AdminModule\Controller\Splitter\AdminSettingController;
use App\Modules\AdminModule\Controller\Splitter\AdminUsersController;
use App\Modules\AdminModule\Controller\Splitter\AdminVariablesController;
use App\Modules\AdminModule\Controller\Splitter\AdminSecurityController;

//Interfaces
use App\Core\Interface\ModuleInterface;

//Module Model
use App\Modules\AdminModule\Model\Admin;
use App\Modules\AdminModule\Model\AdminHrefs;
use App\Middleware\Auth;

/**
 * 
 */
class AdminController extends Controller implements ModuleInterface
{
    
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Admin() of this controller.
     */
    protected $model;
    
    public function __construct($container)
    {
        parent::__construct($container, u: $this->u, model: $this->model);
        
        $container->get(Auth::class)->access(["admin"]);

        //$this->container = $container;
        $this->model = [
            "admin" => new Admin($this->container),
        ];
    }
    
    /**
     * 
     */
    public function initialize(AdminHrefs $admin_hrefs) 
    {
        if(isset($this->u["page"]))
        {
            $dashboard_pages = [
                "dashboard" => "dashboard"
            ];

            $users_pages = [
                "users" => "index",
                "user-show" => "show",
                "user-create" => "createUser",
                "user-upload" => "userUpload",
                "user-verify" => "userVerify",
                "user-change-profile-image" => "userChangeProfileImage",
            ];

            $cli_pages = [
                "phpclis" => "index",
                "phpcli-insert" => "insert",
            ];

            $settings_pages = [
                "settings" => "index",
            ];

            $media_pages = [
                "media" => "mediaIndex",
                "media-picture-show" => "show",
                "media-pictures-insert" => "insert",
                "media-pictures-delete" => "pictureDelete",
                "picture-update-alt" => "updateAltText",
            ];

            $log_pages = [
                "logs" => "index"
            ];

            $security_pages = [
                "security" => "index"
            ];
            
            $this->splitter(AdminDashboardController::class, $dashboard_pages, "Přehled");
            $this->splitter(AdminUsersController::class, $users_pages, "Uživatelé");
            $this->splitter(AdminCLIController::class, $cli_pages, "PHP CLI");
            $this->splitter(AdminSettingController::class, $settings_pages);
            $this->splitter(AdminMediaController::class, $media_pages);
            $this->splitter(AdminLogController::class, $log_pages);
            $this->splitter(AdminSecurityController::class, $security_pages);
        }


        $admin_hrefs_data = $admin_hrefs->getHrefs();
        $this->data = [
            "hrefs" => $admin_hrefs_data,
        ];
    }
}

