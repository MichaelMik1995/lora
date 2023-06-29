<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller\Splitter;

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;

class PortfolioReviewController extends PortfolioController 
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
    private string $template_folder = "review/";

    
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
        $post = $this->input("cnt-review", "required,maxchars4096", "Obsah")
            ->input("item-id","required,maxchars128,url", "ID předmětu")
            ->input("author-name", "maxchars128", "Jméno hodnotícího")
            ->input("rating-evaluation", "required,int")
            ->input("cnt-positives", "maxchars1024", "Klady")
            ->input("cnt-negatives", "maxchars1024", "Zápory")->returnFields();

        $url = rand(11111,99999);

        try {

            //returns true or THROW
            $this->validate();
            $this->model["review"]->insertPortfolioReview([
                "title" => "review-nmb:$url",
                "url" => $url,
                "author" => $post["author-name"],
                "portfolio_url_key" => $post["item-id"],
                "evaluation" => $post["rating-evaluation"],
                "positives" => $post["cnt-positives"],
                "negatives" => $post["cnt-negatives"],
                "content" => $post["cnt-review"],
                "created_at" => time(),
                "updated_at" => time(),
            ]);
            $this->injector["LoraException"]->successMessage("Hodnocení bylo přidáno!");
            @Redirect::redirect("portfolio/item/".$post["item-id"]);
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

