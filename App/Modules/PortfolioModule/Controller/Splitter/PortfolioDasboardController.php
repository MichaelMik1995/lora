<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller\Splitter;

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;

use App\Modules\PortfolioModule\Model\PortfolioTypes;
use App\Modules\PortfolioModule\Model\PortfolioCategory;


class PortfolioDasboardController extends PortfolioController 
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
    private string $template_folder = "Portfolio/";

    protected PortfolioTypes $types;
    protected PortfolioCategory $category;


    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Portfolio";
        $this->injector = $injector;

        $this->types = new PortfolioTypes();
        $this->category = new PortfolioCategory();

        $this->title = "Dashboard";
        
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return void
     */
    public function index() 
    {
        $get_all_types = $this->types->getAllPortfolioTypes();
        $items = $this->model["item"]->getPortfolioPortfolioItemNew();
        
        $this->data = [
            "types" => $get_all_types,
            "items" => $items,
        ]; 

        $this->title = "Portfolio";
    }

    public function showTypes()
    {
        $page = $this->u["page"];
        $this->title = "Dasboard";

        if($page == "all")
        {
            $get_portfolio = $this->types->getAllPortfolioTypes();
            $type_categories = $this->category->getAllPortfolioCategory();
            $color = "#bfbfbf";

            $get_portfolio["title"] = "Vše";
        }
        else
        {
            $type_categories = $this->category->getPortfolioCategoriesByUrl($page);

            $get_portfolio = $this->types->getPortfolioTypes($page);

            $color = $get_portfolio["color"];
        }



        $this->data = [
            "categories" => $type_categories,
            "portfolio_type" => $page,
            "portfolio_title" => $get_portfolio["title"],
            "color" => $color,
            "portfolio" => $get_portfolio
        ];
        
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
        //$this->injector["Auth"]->access(["admin"]);

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
        //$this->injector["Auth"]->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            
            $this->injector["LoraException"]->successMessage("");
            @Redirect::redirect("");
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
        //$this->injector["Auth"]->access(["admin"]);

        $param = $this->u["param"];

        $get = $this->model["model"]->get($param);

        $this->data = [
            "get" => $get,
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."edit";
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update()
    {
        //$this->injector["Auth"]->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();

            $this->injector["LoraException"]->successMessage("Webová stránka přidána!");
            @Redirect::redirect("");
            
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
        //$this->injector["Auth"]->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete

            $this->injector["LoraException"]->successMessage("Příspěvek byl smazán!");
            @Redirect::redirect("");
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

