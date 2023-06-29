<?php
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Controller\Splitter;

use App\Modules\AdmindevModule\Controller\AdmindevController;
//Module Model  


class AdminDevDashboardController extends AdmindevController 
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
        
        $this->module = "Admindev";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    public function dashboard() 
    {
        return $this->view = "dashboard/index";
    }
}

