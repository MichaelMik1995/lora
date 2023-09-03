<?php
declare (strict_types=1);

namespace App\Modules\BlogModule\Controller;

//Core
use App\Controller\Controller;
use App\Middleware\Auth;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Core\Application\Redirect;
use App\Core\DI\DIContainer;

//Interface
use App\Core\Interface\ModuleInterface;

//Module Model
use App\Modules\BlogModule\Model\Blog;

//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;

/**
 *  Main controller for module Blog
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class BlogController extends Controller implements ModuleInterface
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address ex.: (/blog/show/:url) -> $u['url']</p>
     */
    public $u;
    
    /**
     * @instance of main model: Blog() of this controller.
     */
    protected $model;

    //Only DIContainer can be pass as argument in __construct()!
    public function __construct(DIContainer $container)     
    {
        parent::__construct($container, u: $this->u, model: $this->model);
    }
    
    /**
     *  Replaces old index() function for initiliazing module with splitters (IF MODULE IS NOT USE SPLITTERS, USE BASIC CRUD METHODS BELLOW!)
     *
     */
    public function initiliaze() 
    {
      
    }

/* ---------------------------------------------------------------- CRUD METHODS -------------------------------- */
    /**
     * Can use for viewing all tables (rows) in template
     * @return array|void
     */
    public function index(Blog $blog) 
    {
        $get_all = $blog->getAll();
        
        return $this->data = [
            "posts" => $get_all,
        ];
    }

    /**
     * Can use for viewing one table (row) in template
     * @return array|void
     */
    public function show(Blog $blog)
    {
        $url = $this->u["param"];
        $get_one = $blog->get($url);

        return $this->data = [
            "get" => $get_one,
        ];
    }

    /**
     * Can use for viewing form to create a new row
     * @return array|void
     */
    public function create(Blog $blog, Auth $auth, Easytext $easy_text)
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
    public function insert(Blog $blog, Auth $auth, LoraException $lora_exception, StringUtils $string_utils, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $blog->insert([
                "title" => $post["title"],
                "content" => $post["content"],
                "created_at" => time(),
                "updated_at" => time(),
            ]);
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
    public function edit(Blog $blog, Auth $auth, EasyText $easy_text, LoraException $lora_exception)
    {
        //$auth->access(["admin"]);

        $param = $this->u["url"];

        $get = $blog->get($param);

        return $this->data = [
            "post" => $get,
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update(Blog $blog, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $blog->update([
                "title" => $post["title"],
                "content" => $post["content"],
                "updated_at" => time(),
            ]);
            $lora_exception->successMessage("Příspěvek byl upraven!");
            $redirect->to("blog");
            
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
    public function delete(Blog $blog, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete
            $blog->delete();
            $lora_exception->successMessage("Příspěvek byl smazán!");
            $redirect->to();
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }
}

