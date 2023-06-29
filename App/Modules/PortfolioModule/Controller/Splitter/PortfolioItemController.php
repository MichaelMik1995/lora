<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller\Splitter;

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Core\Lib\Utils\StringUtils;

use App\Modules\PortfolioModule\Model\PortfolioItem;


class PortfolioItemController extends PortfolioDasboardController 
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
    private string $template_folder = "item/";

    protected PortfolioItem $item;

    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Portfolio";
        $this->injector = $injector;

        $this->item = new PortfolioItem();
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return string
     */
    public function index() 
    {
        $category = $this->u["page"];
        $items = $this->item->getPortfolioPortfolioItemByCategory($category);

        $get_category_data = $this->category->getPortfolioCategory($category);
        $portfolio = $get_category_data["portfolio_type"];

        $get_portfolio_data = $this->types->getPortfolioTypes($portfolio);
        
        
        $this->data = [
            "items" => $items,
            "category" => $category,
            "category_title" => $get_category_data["title"],
            "portfolio" => $portfolio,
            "portfolio_title" => $get_portfolio_data["title"],
        ];

    }

    /**
     * Can use for viewing one table (row) in template
     * @return string
     */
    public function show()
    {
        $url = $this->u["url"];
        $get_one = $this->item->getPortfolioPortfolioItem($url);

        $get_category_data = $this->category->getPortfolioCategory($get_one["category_url"]);


        $get_portfolio_data = $this->types->getPortfolioTypes($get_category_data["portfolio_type"]);
        $get_reviews = $this->model["review"]->getAllPortfolioReview($url);
        $get_comments = $this->model["comment"]->getAllPortfolioComment($url);

        $this->data = [
            "item" => $get_one,
            "category" => $get_category_data["url"],
            "category_title" => $get_category_data["title"],
            "portfolio" => $get_portfolio_data["url"],
            "portfolio_title" => $get_portfolio_data["title"],
            "reviews" => $get_reviews,
            "comments" => $get_comments,
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
        $category = $this->u["category"];

        
        $categories = $this->types->getAllPortfolioTypesCategories();

        $this->data = [
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1, "height"=>"40em"]),
            "types" => $categories,
            "item_category" => $category,
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
            ->input("short-description", "required,maxchars256", "Krátký popis")
            ->input("category", "required,maxchars128,url", "Kategorie")
            ->input("content", "required,maxchars6000")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $this->item->insertPortfolioPortfolioItem([
                "title" => $post["title"],
                "url" => $url,
                "author" => $this->injector["Auth"]->user_uid,
                "category_url" => $post["category"],
                "short_description" => $post["short-description"],
                "content" => $post["content"],
                "created_at" => time(),
                "updated_at" => time(),
            ], $url);
            $this->injector["LoraException"]->successMessage("Portfolio přidáno!");
            @Redirect::redirect("portfolio/item/$url");
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
        $url = $this->u["url"];
        $categories = $this->types->getAllPortfolioTypesCategories();

        $get_one = $this->item->getPortfolioPortfolioItem($url);


        $this->data = [
            "form" => $this->injector["Easytext"]->form("content", $get_one["content"], ["hide_submit" => 1, "height"=>"40em"]),
            "types" => $categories,
            "item" => $get_one,
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
            ->input("short-description", "required,maxchars256", "Krátký popis")
            ->input("category", "required,maxchars128,url", "Kategorie")
            ->input("item-url", "required,maxchars128,url", "ID Portfolia")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $this->item->updatePortfolioPortfolioItem([
                "title" => $post["title"],
                "author" => $this->injector["Auth"]->user_uid,
                "category_url" => $post["category"],
                "short_description" => $post["short-description"],
                "content" => $post["content"],
                "updated_at" => time(),
            ], $post["item-url"]);
            $this->injector["LoraException"]->successMessage("Upraveno!");
            @Redirect::redirect("portfolio/item/".$post["item-url"]);
            
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

        $post = $this->input("item","required,maxchars128")->input("category","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete
            $this->item->deletePortfolioPortfolioItem($post["item"]);
            $this->injector["LoraException"]->successMessage("Příspěvek byl smazán!");
            @Redirect::redirect("portfolio/category/".$post["category"]);
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    public function deleteItemImage()
    {
        
        $this->injector["Auth"]->access(["admin"]);

        $image = str_replace("_", ".", $_POST['image_name']);
        $url = str_replace("_", ".", $_POST['url']);

        $images_folder = "./App/Modules/PortfolioModule/public/img/item/$url";

        unlink($images_folder . "/image/thumb/$image");
        unlink($images_folder . "/image/$image");
    }
}

