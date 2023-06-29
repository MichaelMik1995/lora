<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

use App\Exception\LoraException;
use App\Modules\AdminModule\Controller\AdminController;
//Module Model  


class AdminCLIController extends AdminController 
{
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;
    
    public $title = "";

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "admin";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    public function index() 
    {
        $log = $this->model["admin-cli"]->getLog();

        $this->data = [
            "log" => $log,
        ];
        return $this->view = "cli/index";
    }

    public function insert()
    {
        $validation = $this->injector["Validation"];
        $command = $_POST["cli_command"];

        $validation->validate($command, ["required", "max_chars512"], "Příkaz");

        if($validation->isValidated() === true)
        {
            $this->model["admin-cli"]->executeCommand($command);
        }
        
    }
}

