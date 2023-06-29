<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller\Splitter;

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioDasboardController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;

class PortfolioCategoryController extends PortfolioDasboardController 
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
    private string $template_folder = "category/";


    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Portfolio";
        $this->injector = $injector;

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
        $url = $this->u["type"];
        $get_one = $this->model[""]->get($url);

        $this->data = [
            "get" => $get_one,
        ];

        return $this->view = $this->template_folder."show";
    }

    /**
     * Can use for viewing form to create a new row
     * @return void
     */
    public function create()
    {
        $this->injector["Auth"]->access(["admin"]);
        $portfolio_type = $this->u["page"];
        $types = $this->types->getAllPortfolioTypes();

        $this->data = [
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1]),
            "types" => $types,
            "portfolio_type" => $portfolio_type,
        ];
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
            ->input("type", "required,maxchars128,url", "Portfolio")
            ->input("description", "required,maxchars6000")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $this->category->insertPortfolioCategory([
                "title" => $post["title"],
                "url" => $url,
                "portfolio_type" => $post["type"],
                "description" => $post["description"],
            ], $url);
            
            $this->injector["LoraException"]->successMessage("Kategorie přidána!");
            @Redirect::redirect("portfolio/category/".$url);
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

        $type = $this->u["type"];
        $category = $this->u["category"];

        $get_one = $this->category->getPortfolioCategory($category);
        $types = $this->types->getAllPortfolioTypes();

        $this->data = [
            "category" => $get_one,
            "types" => $types,
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
            ->input("url", "required,maxchars128,url", "ID Kategorie")
            ->input("type", "required,maxchars128,url", "Portfolio")
            ->input("description", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $this->category->updatePortfolioCategory([
                "title" => $post["title"],
                "portfolio_type" => $post["type"],
                "description" => $post["description"],
            ], $post["url"]);
            $this->injector["LoraException"]->successMessage("Webová stránka přidána!");
            @Redirect::redirect("portfolio/category/".$post["url"]);
            
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

        $post = $this->input("category","required,maxchars128,url")
                ->input("portfolio","required,maxchars128,url")->returnFields();

        try {
            $this->validate();
            //delete
            $this->category->deletePortfolioCategoryData($post["category"]);
            $this->category->deletePortfolioCategory($post["category"]);
            $this->injector["LoraException"]->successMessage("Kategorie byla smazána!");
            @Redirect::redirect("portfolio/types/".$post["portfolio"]);
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

