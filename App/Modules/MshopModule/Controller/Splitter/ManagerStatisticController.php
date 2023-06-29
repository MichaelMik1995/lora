<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerStatisticController extends MshopController 
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
    protected $main_model;
    protected $title;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        //$this->main_model = new ()
    }
    
    
    public function index() 
    {
      
    }
}

