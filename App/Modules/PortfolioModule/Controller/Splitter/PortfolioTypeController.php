<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller\Splitter;

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Core\Lib\Utils\StringUtils;
use App\Modules\PortfolioModule\Model\PortfolioCategory;
use App\Modules\PortfolioModule\Model\PortfolioTypes;


class PortfolioTypeController extends PortfolioController 
{
    use Redirect;
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;

    /**
     * Template folder
     * @var string $template_folder
     */
    private string $template_folder = "types/";

    private PortfolioTypes $types;


    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Portfolio";
        $this->injector = $injector;

        $this->types = new PortfolioTypes();
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
        $this->injector["Auth"]->access(["admin"]);
        $this->title = "Nové portfolio";
        $this->data = [
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."create";
    }

    /**
     * Can use for validation data from create form and save
     * @return void
     */
    public function insert()
    {
        $this->injector["Auth"]->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("color", "maxchars64", "Barva portfolia")
            ->input("description", "required,maxchars128", "Popis")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $this->types->insertPortfolioTypes([
                "title" => $post["title"],
                "url" => $url,
                "description" => $post["description"],
                "color" => $post["color"],
            ], $url);
            $this->injector["LoraException"]->successMessage("Portfolio vytvořeno!");
            @Redirect::redirect("portfolio");
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return string
     */
    public function edit()
    {
        $this->injector["Auth"]->access(["admin"]);

        $param = $this->u["param"];

        $get = $this->types->getPortfolioTypes($param);

        $this->data = [
            "portfolio" => $get,
        ];
        return $this->view = $this->template_folder."edit";
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update()
    {
        $this->injector["Auth"]->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("description", "required,maxchars256", "Krátký popis")
            ->input("color", "required,maxchars64", "Barva")
            ->input("url", "required,maxchars128,url", "ID portfolia")->returnFields();

        try {
            $this->validate();
            $this->types->updatePortfolioTypes([
                "title" => $post["title"],
                "description" => $post["description"],
                "color" => $post["color"],
            ], $post["url"]);
            $this->injector["LoraException"]->successMessage("Webová stránka upravena!");
            @Redirect::redirect("portfolio");
            
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for deleting row
     * @return void
     */
    public function delete()
    {
        $this->injector["Auth"]->access(["admin"]);

        $post = $this->input("type","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete
            $this->types->deletePortfolioTypes($this->model["category"], $this->model["item"], $post["type"]);
            $this->injector["LoraException"]->successMessage("Příspěvek byl smazán!");
            @Redirect::redirect("portfolio");
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

