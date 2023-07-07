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

    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Admindev";
        $this->injector = $injector;
    }
    
    
    public function dashboard() 
    {
        return $this->view = "dashboard/index";
    }
}

