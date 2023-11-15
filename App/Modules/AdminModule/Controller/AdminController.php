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
use App\Modules\AdminModule\Controller\Splitter\AdminSchedulerController;
use App\Modules\AdminModule\Controller\Splitter\AdminAnnouncementsController;

//Interfaces
use App\Core\Interface\ModuleInterface;
use App\Exception\LoraException;

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

        //Check if user is admin and authorized
        if(!$container->get(Auth::class)->isAuth(["admin", "developer"]))
        {
            $container->get(LoraException::class)->errorMessage("You are not authorized to access this page.");
            $container->get(Redirect::class)->to();
        }
    }
    
    /**
     * 
     */
    public function initialize(AdminHrefs $admin_hrefs, Auth $auth, Redirect $redirect) 
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
                "user-admin-grant" => "userAdminGrant",
                "user-admin-remove" => "userAdminRemove",
                "user-password-reset" => "userPasswordReset",
                "user-password-force-reset" => "userPasswordForceReset",
                "user-remove" => "userRemove",
                "user-log" => "userLog",
                
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

            $scheduler_pages = [
                "scheduler" => "index",
                "scheduler-force-archive-log" => "forceArchiveLog",
                "scheduler-change-interval" => "changeArchiveLogInterval",
            ];

            $banned_pages = [
                "bannedips" => "index",
            ];

            $announcements_pages = [
                "announcements" => "index",
                "announcement-insert" => "insert",
            ];

            
            $this->splitter(AdminDashboardController::class, $dashboard_pages, "Přehled");
            $this->splitter(AdminUsersController::class, $users_pages, "Uživatelé");
            $this->splitter(AdminCLIController::class, $cli_pages, "PHP CLI");
            $this->splitter(AdminSettingController::class, $settings_pages);
            $this->splitter(AdminMediaController::class, $media_pages, "Média");
            $this->splitter(AdminLogController::class, $log_pages, "Logy");
            $this->splitter(AdminSecurityController::class, $security_pages, "Zabezpečení");
            $this->splitter(AdminSchedulerController::class, $scheduler_pages, "Plánovač");
            $this->splitter(AdminBanController::class, $banned_pages, "Ban blacklist");
            $this->splitter(AdminAnnouncementsController::class, $announcements_pages, "Announcements");
        
            $admin_hrefs_data = $admin_hrefs->getHrefs();
            $this->data = [
                "hrefs" => $admin_hrefs_data,
            ];
        }
        else
        {
            $redirect->to("admin/app/dashboard");
        }

        
    }
}

