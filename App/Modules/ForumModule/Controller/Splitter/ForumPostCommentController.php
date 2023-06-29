<?php
declare (strict_types=1);

namespace App\Modules\ForumModule\Controller\Splitter;

use App\Modules\ForumModule\Controller\ForumController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  
use App\Core\Lib\Utils\StringUtils;

class ForumPostCommentController extends ForumController 
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

        //Fill $post variable with values of form fields
        $post = $this->input("post-url", "required,maxchars128,url", "ID Příspěvku")
            ->input("reply", "required,maxchars128,url")
            ->input("content", "required,maxchars6000", "Obsah komentáře")->returnFields();

        $string_utils = StringUtils::instance();
        $url = $string_utils->toSlug($post["post-url"]).rand(111111,999999);

        $post_data = $this->model["post"]->getForumPost($post["post-url"]);

        try {

            //returns true or THROW
            $this->validate();

            //If post is NOT closed
            if($post_data["solved"] == 0)
            {
                $this->model["comment"]->insertForumComment([
                    "author" => $this->injector["Auth"]->user_uid,
                    "url" => $url,
                    "post_url" => $post["post-url"],
                    "reply_to" => $post["reply"],
                    "content" => $post["content"],
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);
            }
            else
            {
                $this->injector["LoraException"]->errorMessage("Nelze psát komentáře do uzavřeného příspěvku!");
                @Redirect::redirect("forum/post-show/".$post["post-url"]);
            }

            $this->injector["LoraException"]->successMessage("Komentář byl úspěšně přidán");
            @Redirect::redirect("forum/post-show/".$post["post-url"]);
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

    public function badComment()
    {
        $comment_url = $this->u["url"];
        $get_comment_row = $this->model["comment"]->getForumComment($comment_url);
        
        //Check, if review is empty
        $post_data = $this->model["post"]->getForumPost($get_comment_row["post_url"]);
        $bad = $get_comment_row["bad_comment"];


        if($post_data["solved"] !=1)
        {
            try {
                $new_number = $bad+1;
                $this->model["comment"]->updateForumComment([
                    "bad_comment" => $new_number,
                ], $comment_url);
                @Redirect::redirect("forum/post-show/".$get_comment_row["post_url"]);
            }catch(LoraException $ex)
            {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
                @Redirect::previous();
            }
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Již nelze hodnotit komentář! Příspěvek je uzavřen!");
            @Redirect::previous();
        }

    }

     public function greatComment()
     {
        $comment_url = $this->u["url"];
        $get_comment_row = $this->model["comment"]->getForumComment($comment_url);
        
        //Check, if review is empty
        $post_data = $this->model["post"]->getForumPost($get_comment_row["post_url"]);
        $great = $get_comment_row["bad_comment"];


        if($post_data["solved"] !=1)
        {
            try {
                $new_number = $great+1;
                $this->model["comment"]->updateForumComment([
                    "great_comment" => $new_number,
                ], $comment_url);
                @Redirect::redirect("forum/post-show/".$get_comment_row["post_url"]);
            }catch(LoraException $ex)
            {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
                @Redirect::previous();
            }
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Již nelze hodnotit komentář! Příspěvek je uzavřen!");
            @Redirect::previous();
        }
     }
}

