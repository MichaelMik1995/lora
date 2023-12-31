<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller\Splitter;

//Main module Controller
use App\Modules\UserModule\Controller\UserController;

//Core
use App\Middleware\Auth;
use App\Core\Application\Redirect;
use App\Core\DI\DIContainer;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  


//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;
use App\Model\AuthManager;


use App\Modules\UserModule\Model\UserPassword;
/**
 *  Main controller for module {Model_name}
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class UserPasswordController extends UserController 
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;

    /**
     * Template folder
     * @var string $template_folder
     */
    private string $template_folder = "password/";

    /**
     * Splitter Title
     *
     * @var string
     */
    protected string $splitter_title = "";

    
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
        
        $this->module = "User";
    }
    
    public function passwordDashboard()
    {
        return $this->view = $this->template_folder."index";
    }
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return void
     */
    public function changePassword(UserPassword $password, LoraException $lora_exception, Redirect $redirect, Auth $auth, AuthManager $auth_manager)
    {
        $post = $this->input("current-password", "required,maxchars128", "Současné heslo")
        ->input("new-password", "required,maxchars128", "Nové heslo")
        ->input("again-password", "required,maxchars128", "Nové heslo znovu")
        ->returnFields();

        try {
            $this->validate();
            $password->updateUserPassword($post, $auth->user_uid, $auth_manager);

            $lora_exception->successMessage("Heslo bylo změněno! Nyní Vás odhlásíme");
            $redirect->to("auth/logout");
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }

        
    }

    /**
     * Can use for viewing one table (row) in template
     * @return string
     */
    public function show($model)
    {
        $url = $this->u["param"];
        $get_one = $model->get($url);

        $this->data = [
            "get" => $get_one,
        ];

        return $this->view = $this->template_folder."show";
    }

    /**
     * Can use for viewing form to create a new row
     * @return string
     */
    public function create($model, Auth $auth, EasyText $easy_text)
    {
        //$tauth->access(["admin"]);

        $this->data = [
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."create";
    }

    /**
     * Can use for validation data from create form and save
     * @return void
     */
    public function insert($model, Auth $auth, StringUtils $string_utils, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            //model insert method

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
     * @return string
     */
    public function edit($model, Auth $auth, EasyText $easy_text)
    {
        //$auth->access(["admin"]);

        $param = $this->u["param"];

        $get = $model->get($param);

        $this->data = [
            "get" => $get,
            "form" => $easy_text->form("content", "", ["hide_submit" => 1])
        ];
        return $this->view = $this->template_folder."edit";
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update($model, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
            ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            //model update method

            $lora_exception->successMessage("Webová stránka přidána!");
            $redirect->to();
            
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
    public function delete($model, Auth $auth, LoraException $lora_exception, Redirect $redirect)
    {
        //$auth->access(["admin"]);

        $post = $this->input("url","required,maxchars128")->returnFields();

        try {
            $this->validate();
            //model delete method

            $lora_exception->successMessage("Příspěvek byl smazán!");
            $redirect->to();
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            $redirect->previous();
        }
    }
}

