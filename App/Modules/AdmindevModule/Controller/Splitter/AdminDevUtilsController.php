<?php
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Controller\Splitter;

use App\Modules\AdmindevModule\Controller\AdmindevController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;
use App\Model\AuthManager;

class AdminDevUtilsController extends AdmindevController 
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;

    /**
     * Template folder
     * @var string $template_folder
     */
    private string $template_folder = "utils/";

    private AuthManager $auth_manager;

    
    public function __construct($container)
    {
        parent::__construct($container);
        
        $this->module = "Admindev";
        $this->container = $container;
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return string
     */
    public function index() 
    {
        /* $get_all = $this->model[""]->getAll();
        
        $this->data = [
            "all" => $get_all,
        ]; */

        return $this->view = $this->template_folder."index";
    }

    public function generatePassword(AuthManager $auth_manager)
    {
        $post = $this->input("gen-password", "required,maxchars1024", "Heslo")->returnFields();
        $this->data = [
            "original_password" => $post["gen-password"],
            "hash" => $auth_manager->password_hash($post["gen-password"]),
        ];
        return $this->view = $this->template_folder."/password/generated_password";
    }

    /**
     * Can use for viewing one table (row) in template
     * @return string
     */
    public function show()
    {
        $url = $this->u["param"];
        $get_one = $this->model[""]->get($url);

        $this->data = [
            "get" => $get_one,
        ];

        return $this->view = $this->template_folder."show";
    }

    /**
     * Can use for viewing form to create a new row
     * @return string
     */
    public function create()
    {
        //$this->container["Auth"]->access(["admin"]);

        $this->data = [
            "form" => $this->container["Easytext"]->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."create";
    }

    /**
     * Can use for validation data from create form and save
     * @return void
     */
    public function insert()
    {
        //$this->container["Auth"]->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            
            $this->container["LoraException"]->successMessage("");
            @Redirect::redirect("");
        }catch(LoraException $ex)
        {
            $this->container["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return string
     */
    public function edit()
    {
        //$this->container["Auth"]->access(["admin"]);

        $param = $this->u["param"];

        $get = $this->model["model"]->get($param);

        $this->data = [
            "get" => $get,
            "form" => $this->container["Easytext"]->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."edit";
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update()
    {
        //$this->container["Auth"]->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();

            $this->container["LoraException"]->successMessage("Webová stránka přidána!");
            @Redirect::redirect("");
            
        }catch(LoraException $ex)
        {
            $this->container["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for deleting row
     * @return void
     */
    public function delete()
    {
        //$this->container["Auth"]->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete

            $this->container["LoraException"]->successMessage("Příspěvek byl smazán!");
            @Redirect::redirect("");
        }catch(LoraException $ex)
        {
            $this->container["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

