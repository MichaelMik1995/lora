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
    protected $container;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;

    
    public function __construct($container)
    {
        parent::__construct($container);
        
        $this->module = "Admindev";
        $this->container = $container;
    }
    
    
    public function dashboard() 
    {
        return $this->view = "dashboard/index";
    }
}

