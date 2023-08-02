<?php
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Controller;

use App\Controller\Controller;
use App\Modules\AdmindevModule\Controller\Splitter\AdminDevDashboardController;
use App\Modules\AdmindevModule\Controller\Splitter\AdminDevCLIController;
use App\Modules\AdmindevModule\Controller\Splitter\AdminDevModulesController;


//Module Model
use App\Core\Application\Redirect;
use App\Modules\AdmindevModule\Controller\Splitter\AdminDevUtilsController;
use App\Modules\AdmindevModule\Model\AdmindevHrefs;    
use App\Modules\AdmindevModule\Model\AdmindevCLI;
use App\Modules\AdmindevModule\Model\AdmindevModule;
use App\Core\DI\DIContainer;
use App\Middleware\Auth;
use App\Exception\LoraException;


class AdmindevController extends Controller 
{
    
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Admindev() of this controller.
     */
    protected $model;

    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $admindev_controll;

    
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);

        //Check if user is admin and authorized
        if(!$container->get(Auth::class)->isAuth(["admin","developer"]))
        {
            $container->get(LoraException::class)->errorMessage("You are not authorized to access this page.");
            $container->get(Redirect::class)->to();
        }
    }
    
    public function initialize(AdmindevHrefs $admin_hrefs, Redirect $redirect)
    {
        if(!isset($this->u["page"]))
        {
            $redirect->to("admindev/app/dashboard");
        }


        $admin_hrefs = $admin_hrefs->getHrefs();

        $this->data = [
            "hrefs" => $admin_hrefs,
        ];

        $dashboard_pages = [
            "dashboard" => "dashboard",
        ];

        $modules_pages = [
            "modules" => "index",
            "module-create" => "create",
            "module-insert" => "insert",
            "module-delete" => "delete",
        ];

        $cli_pages = [
            "phpclis" => "index",
        ];

        $util_pages = [
            "utils" => "index",
            "util-generate-psw" => "generatePassword",
        ];

        $this->splitter(AdminDevDashboardController::class, $dashboard_pages, "Přehled");
        $this->splitter(AdminDevModulesController::class, $modules_pages, "Moduly");
        $this->splitter(AdminDevCLIController::class, $cli_pages, "Admin CLI");
        $this->splitter(AdminDevUtilsController::class, $util_pages, "Utility");
    }
}

