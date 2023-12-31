<?php
declare (strict_types=1);

namespace App\Modules\HomepageModule\Controller;

//Core
use App\Controller\Controller;
use App\Middleware\Auth;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Core\Application\Redirect;

//Interface
use App\Core\Interface\ModuleInterface;

//Module Model
use App\Modules\HomepageModule\Model\Homepage;

//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;

/**
 *  Main controller for module Homepage
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class HomepageController extends Controller implements ModuleInterface
{
    use FormValidator;
    

    /**
     * @var array <p>Injected classes to controller</p>
     */
    public $container;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Homepage() of this controller.
     */
    protected $model;


    public function __construct($container)
    {
        parent::__construct($container, u: $this->u, model: $this->model);
        
        $this->container = $container;
    }
    
    /**
     *  Replaces old index() function for initiliazing module with splitters (IF MODULE IS NOT USE SPLITTERS, USE BASIC CRUD METHODS BELLOW!)
     *
     */
    public function initiliaze() 
    {
        $this->title = "Vítejte";
    }

/* ---------------------------------------------------------------- CRUD METHODS -------------------------------- */
    /**
     * Can use for viewing all tables (rows) in template
     * @return array|void
     */
    public function index(Homepage $model) 
    {
        /* $get_all = $model->getAll();
        
        return $this->data = [
            "all" => $get_all,
        ]; */  
    }

    /**
     * Can use for viewing one table (row) in template
     * @return array|void
     */
    public function show(Homepage $model)
    {
        $url = $this->u["param"];
        $get_one = $model->get($url);

        return $this->data = [
            "get" => $get_one,
        ];
    }

    /**
     * Can use for viewing form to create a new row
     * @return array|void
     */
    public function create(Auth $auth, Homepage $model, Easytext $easy_text)
    {
        //$auth->access(["admin"]);

        return $this->data = [
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
    }

    /**
     * Can use for validation data from create form and save
     * @return void
     */
    public function insert(Auth $auth, Homepage $model, LoraException $lora_exception, StringUtils $string_utils)
    {
        //$auth->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            
            $lora_exception->successMessage("");
            $redirect->to();
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return array|void
     */
    public function edit(Auth $auth, Homepage $model, EasyText $easy_text, LoraException $lora_exception)
    {
        //$auth->access(["admin"]);

        $param = $this->u["param"];

        $get = $model->get($param);

        return $this->data = [
            "get" => $get,
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update(Auth $auth, Homepage $model, LoraException $lora_exception)
    {
        //$auth->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();

            $lora_exception->successMessage("Webová stránka přidána!");
            $redirect->to();
            
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }

    /**
     * Can use for deleting row
     * @return void
     */
    public function delete(Auth $auth, Homepage $model, LoraException $lora_exception)
    {
        //$auth->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete

            $lora_exception->successMessage("Příspěvek byl smazán!");
            $redirect->to();
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }
}

