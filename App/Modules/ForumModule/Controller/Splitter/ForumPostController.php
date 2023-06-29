<?php
declare (strict_types=1);

namespace App\Modules\ForumModule\Controller\Splitter;

use App\Modules\ForumModule\Controller\ForumController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\Utils\UserUtils;
use App\Core\Database\DB;

class ForumPostController extends ForumController 
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
    private string $template_folder = "post/";

    
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
        
        $category_url = $this->u["category"];
        $category = $this->model["category"]->getForumThemeCategory($category_url);
        $theme = $this->model["theme"]->getForumTheme($category["theme_url"]);

        //Posts
        $posts = $this->model["post"]->getAllForumPostByCategory($theme["url"], $category_url);
        

        $this->data = [
            "theme" => $theme,
            "category" => $category,
            "posts" => $posts,
            "style" => $this->model["style"]->getForumStyle($this->injector["Config"]->var("FORUM_THEME")),
        ];

        $this->title = $theme["name"]." > ".$category["name"];

    }

    /**
     * Can use for viewing one table (row) in template
     * @return void
     */
    public function show()
    {
        $user_utils = UserUtils::instance(DB::instance());

        $url = $this->u["url"];
        $get_one = $this->model["post"]->getForumPost($url);

        $category = $get_one["category_url"];
        $explode = explode("@", $category);

        $this->data = [
            "post" => $get_one,
            "user_utils" => $user_utils,
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1]),
            "user_uid" => $this->injector["Auth"]->user_uid,
            "is_admin" => $this->injector["Auth"]->isAuth(["admin,editor,developer"]),
            "category" => $explode[1],
            "style" => $this->forum_style,
        ];

        $this->title = $get_one["title"];

    }

    /**
     * Can use for viewing form to create a new row
     * @return string
     */
    public function create()
    {
        $this->title = "Nové vlákno";
        //$this->injector["Auth"]->access(["admin"]);
        $category_url = $this->u["category"];
        $category = $this->model["category"]->getForumThemeCategory($category_url);
        $theme = $this->model["theme"]->getForumTheme($category["theme_url"]);

        $this->data = [
            "category_url" => $category_url,
            "theme_url" => $theme["url"],
            "theme_name" => $theme["name"],
            "category_name" => $category["name"],
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
        //Fill $post variable with values of form fields
        $post = $this->input("name", "required,maxchars128", "Název")
            ->input("theme-url", "required,maxchars128,url")
            ->input("category-url", "required,maxchars128,url")
            ->input("content", "required,maxchars6000", "Obsah")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["name"]);

        try {

            //returns true or THROW
            $this->validate();
            $this->model["post"]->insertForumPost([
                "title" => $post["name"],
                "author" => $this->injector["Auth"]->user_uid,
                "url" => $url,
                "category_url"=>$post["theme-url"]."@".$post["category-url"],
                "content" => $post["content"],
                "solved" => "0",
                "created_at" => time(),
                "updated_at" => time(),
            ]);

            $this->injector["LoraException"]->successMessage("Vlákno bylo vytvořeno");
            @Redirect::redirect("forum/post-show/$url");
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

        $this->title = "Upravit vlákno";
        $post_url = $this->u["url"];
        $get_one = $this->model["post"]->getForumPost($post_url);

        if(!($this->injector["Auth"]->user_uid == $get_one["author"] || $this->injector["Auth"]->isAuth(["admin,editor,developer"])))
        {
            $this->injector["LoraException"]->errorMessage("Nejste autor příspěvku nebo nemáte oprávnění k editaci!");
            @Redirect::redirect("forum/post-show/".$get_one["post-url"]);
        }

        $this->data = [
            "post" => $get_one,
            "form" => $this->injector["Easytext"]->form("content", $get_one["content"], ["hide_submit" => 1])
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
            ->input("post-url", "required,maxchars128,url", "ID Vlákna")
            ->input("author", "required,maxchars128", "Autor")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            if($this->injector["Auth"]->user_uid == $post["author"] || $this->injector["Auth"]->isAuth(["admin,editor,developer"]))
            {
                $this->model["post"]->updateForumPost([
                    "title" => $post["title"],
                    "content" => $post["content"],
                    "updated_at" => time(),
                ], $post["post-url"]);
                $this->injector["LoraException"]->successMessage("Vlákno bylo upraveno");
                @Redirect::redirect("forum/post-show/".$post["post-url"]);
            }
            else
            {
                $this->injector["LoraException"]->errorMessage("Nejste autor příspěvku nebo nemáte oprávnění k editaci!");
                @Redirect::redirect("forum/post-show/".$post["post-url"]);
            }
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

    public function close()
    {
        $post_url = $this->u["url"];
        $post = $this->model["post"]->getForumPost($post_url);

        if($this->injector["Auth"]->user_uid == $post["author"] || $this->injector["Auth"]->isAuth(["admin,editor,developer"]))
            {
                $this->model["post"]->closeForumPost($post_url);
                $this->injector["LoraException"]->successMessage("Vlákno bylo uzavřeno");
                @Redirect::redirect("forum/post-show/".$post["url"]);
            }
            else
            {
                $this->injector["LoraException"]->errorMessage("Nejste autor příspěvku nebo nemáte oprávnění k editaci!");
                @Redirect::redirect("forum/post-show/".$post["url"]);
            }
    }

    public function open()
    {
        $post_url = $this->u["url"];
        $post = $this->model["post"]->getForumPost($post_url);

        $this->model["post"]->openForumPost($post_url);
        $this->injector["LoraException"]->successMessage("Vlákno bylo otevřeno");
        @Redirect::redirect("forum/post-show/".$post["url"]);
    }
}

