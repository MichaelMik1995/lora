<?php
declare (strict_types=1);

namespace App\Modules\ForumModule\Controller\Splitter;

use App\Modules\ForumModule\Controller\ForumController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;

class ForumThemeController extends ForumController 
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
    private string $template_folder = "Forum/";

    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Forum";
        $this->injector = $injector;
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return void
     */
    public function index() 
    {
        //Get All categories from specific forum

        $theme_url = $this->u["theme"];
        $forum_data = $this->model["theme"]->getForumTheme($theme_url, 50);
        

        $this->data = [
            "theme" => $forum_data,
            "style" => $this->forum_style,
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
            ->input("icon", "required,maxchars128", "FA Ikona")
            ->input("content", "required,maxchars2048", "Popis")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $this->model["theme"]->insertForumTheme([
                "name" => $post["title"],
                "url" => $url,
                "content" => $post["content"],
                "icon" => $post["icon"],
            ]);
            $this->injector["LoraException"]->successMessage("Téma bylo přidáno");
            @Redirect::redirect("forum");
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return void
     */
    public function edit()
    {
        //$this->injector["Auth"]->access(["admin"]);

        $param = $this->u["theme"];

        $get = $this->model["theme"]->getForumTheme($param);

        $this->data = [
            "theme" => $get,
            "form" => $this->injector["Easytext"]->form("content", $get['content'], ["hide_submit" => 1])
        ];
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update()
    {
        //$this->injector["Auth"]->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("icon", "required,maxchars128", "Ikona")
            ->input("url", "required,maxchars128,url", "ID Tématu")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $this->model["theme"]->updateForumTheme([
                "name" => $post["title"],
                "content" => $post["content"],
                "icon" => $post["icon"],
            ], $post["url"]);
            $this->injector["LoraException"]->successMessage("Téma bylo upraveno");
            @Redirect::redirect("forum/theme/show/".$post["url"]);
            
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
            $this->model["theme"]->deleteForumTheme($post["url"]);
            $this->injector["LoraException"]->successMessage("Téma bylo smazáno!");
            @Redirect::redirect("forum");
        }catch(LoraException $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

