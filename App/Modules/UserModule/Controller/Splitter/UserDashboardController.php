<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller\Splitter;

use App\Modules\UserModule\Controller\UserController;
use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;  


class UserDashboardController extends UserController 
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
    private string $template_folder = "User/";

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "User";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return string
     */
    public function index() 
    {
        return $this->view = $this->template_folder."index";
    }

    /**
     * Can use for viewing one table (row) in template
     * @return string
     */
    public function show()
    {
        return $this->view = $this->template_folder."show";
    }

    /**
     * Can use for viewing form to create a new row
     * @return string
     */
    public function create()
    {
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

    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return string
     */
    public function edit()
    {
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

    }

    /**
     * Can use for deleting row
     * @return void
     */
    public function delete()
    {

    }
}

