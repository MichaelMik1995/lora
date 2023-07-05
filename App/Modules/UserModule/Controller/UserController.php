<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller;

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
use App\Modules\UserModule\Model\User;

//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;

/**
 *  Main controller for module User
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class UserController extends Controller implements ModuleInterface
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address ex.: (/user/show/:url) -> $u['url']</p>
     */
    public $u;
    
    /**
     * @instance of main model: User() of this controller.
     */
    protected $model;

    public function __construct(DIContainer $container)
    {
        parent::__construct($container, u: $this->u, model: $this->model);
        if(!$container->get(Auth::class)->isLogged())
        {
            $container->get(LoraException::class)->errorMessage('You must be logged in to access this page.');
            $container->get(Redirect::class)->to('auth/login');
        }
    }
    
    /**
     *  Replaces old index() function for initiliazing module with splitters (IF MODULE IS NOT USE SPLITTERS, USE BASIC CRUD METHODS BELLOW!)
     *
     */
    public function initiliaze(User $user) 
    {
        
    }

/* ---------------------------------------------------------------- CRUD METHODS -------------------------------- */
    /**
     * Can use for viewing all tables (rows) in template
     * @return array|void
     */
    public function index(User $user) 
    {
        /* $get_all = $user->getAll();
        
        return $this->data = [
            "all" => $get_all,
        ]; */
    }

    /**
     * Can use for viewing one table (row) in template
     * @return array|void
     */
    public function show(User $user)
    {
        $url = $this->u["param"];
        $get_one = $user->get($url);

        return $this->data = [
            "get" => $get_one,
        ];
    }

    /**
     * Can use for viewing form to create a new row
     * @return array|void
     */
    public function create(User $user, Auth $auth, Easytext $easy_text)
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
    public function insert(User $user, Auth $auth, LoraException $lora_exception, StringUtils $string_utils, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $user->insert([
                "title" => $post["title"],
                "content" => $post["content"],
                "created_at" => time(),
                "updated_at" => time(),
            ]);
            $lora_exception->successMessage("");
            $redirect->to("");
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
    public function edit(User $user, Auth $auth, EasyText $easy_text, LoraException $lora_exception)
    {
        //$auth->access(["admin"]);

        $param = $this->u["param"];

        $get = $user->get($param);

        return $this->data = [
            "get" => $get,
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update(User $user, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $user->update([
                "title" => $post["title"],
                "content" => $post["content"],
                "updated_at" => time(),
            ]);
            $lora_exception->successMessage("Webová stránka přidána!");
            $redirect->to("");
            
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
    public function delete(User $user, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //delete
            $user->delete();
            $lora_exception->successMessage("Příspěvek byl smazán!");
            $redirect->to("");
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }
}

