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


class AdmindevController extends Controller 
{
    use Redirect;
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Admindev() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $admindev_controll;

    
    public function __construct($injector)
    {
        parent::__construct($injector);

        //$injector["Auth"]->access(["admin", "developer"]);
        $this->injector = $injector;
        $this->model = [
            "admindev-hrefs" => new AdmindevHrefs(),
            "admindev-cli" => new AdmindevCLI(),
            "admindev-module" => new AdmindevModule(),
        ];
    }
    
    
    public function index() 
    {
        if(!isset($this->u["page"]))
        {
            @Redirect::redirect("admindev/app/dashboard");
        }


        $admin_hrefs = $this->model["admindev-hrefs"]->getHrefs();

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

