<?php
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Controller\Splitter;

use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Modules\AdmindevModule\Controller\AdmindevController;
use App\Modules\AdmindevModule\Model\AdmindevModule;
use App\Core\Lib\FormValidator;
use App\Core\DI\DIContainer;

//Module Model  

//Utils
use Lora\Easytext\Easytext;


class AdminDevModulesController extends AdmindevController 
{
    use FormValidator;
    /**
     * @var array <p>Injected classes to controller</p>
     */
    
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;

    protected AdmindevModule $admin_module;

    
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
        $this->module = "Admindev";
    }

    
    
    public function index(AdmindevModule $admin_module) 
    {
        $get_modules = $admin_module->getModules();
        $this->data = [
            "modules" => $get_modules,
        ];

        $this->title = "Přehled modulů";
        return $this->view = "module/index"; 
    }

    public function create(EasyText $easyText)
    {
        $this->data = [
            "WEB_VERSION" => env("web_version", false),
            "form" => $easyText->form("description", "Description of module", ["hide_submit"=>true]),
        ];
        return $this->view = "module/create";
    }

    public function insert(AdmindevModule $admin_module, AdmindevModule $module_model, Redirect $redirect)
    {
        //Form validator
        $this->input("name", ["required", "maxchars64"])
            ->input("model")
            ->input("splitter")
            ->input("database-tables", "0:1")
            ->input("database-data", "0:1")
            ->input("check-templates", "0:1")
            ->input("template-folder-name", "maxchars64")
            ->input("version", "maxchars11")
            ->input("category", "maxchars64")
            ->input("icon", "maxchars64")
            ->input("short-description", "maxchars256")
            ->input("description", "maxchars9999")->check();

        //Return fields -> healed -> checked
        $post = $this->returnFields();

        try {
            $this->validate();

            $module_name = $post["name"];
            $module_model->createModule($module_name);
            $module_model->createSplitters($module_name, $post["splitter"], $post["template-folder-name"]);
            $module_model->createModels($module_name, $post["model"]);

            $module_model->databaseFiles($module_name, intval($post["database-tables"]), intval($post["database-data"]));
            $module_model->createConfigFile($module_name, $post["version"], $post["category"], $post["short-description"], $post["icon"]);
            $module_model->createReadmeFile($module_name, $post["description"]);

            $this->container->get(LoraException::class)->successMessage("Modul byl úspěšně vytvořen");
            $redirect->to("admindev/app/modules");

        }catch(LoraException $ex)
        {
            $this->container->get(LoraException::class)->errorMessage($ex->getMessage());
        }

    }

    public function delete()
    {
        $name = $this->u["param"];

        $module_name = ucfirst($name);
        shell_exec("rm -rf ./App/Modules/".$module_name."Module");
        $this->container->get(LoraException::class)->successMessage("Modul byl úspěšně smazán");
        @Redirect::redirect("admindev/app/modules");
    }
}

