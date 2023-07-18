<?php
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Controller\Splitter;

use App\Modules\AdmindevModule\Controller\AdmindevController;
//Module Model  


class AdminDevCLIController extends AdmindevController 
{
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $container;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;
    
    public $title = "";

    
    public function __construct($container, $model)
    {
        parent::__construct($container);
        
        $this->module = "Admindev";
        $this->container = $container;
        $this->model = $model;
    }
    
    
    public function index() 
    {
        $log = $this->model["admindev-cli"]->getLog();

        $this->data = [
            "log" => $log,
        ];
        return $this->view = "cli/index";
    }

    public function insert()
    {
        $validation = $this->container["Validation"];
        $command = $_POST["cli_command"];

        $validation->validate($command, ["required", "max_chars512"], "Příkaz");

        if($validation->isValidated() === true)
        {
            $this->model["admindev-cli"]->executeCommand($command);
        }
        
    }
}

