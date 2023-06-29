<?php
declare (strict_types=1);

namespace App\Modules\GamesModule\Controller\Splitter;

use App\Core\Application\Redirect;
use App\Modules\GamesModule\Controller\GamesController;
//Module Model  


class GamesHomeDashboardController extends GamesController 
{
    use Redirect;
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
    public $model;
    
    public $title = "";

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "Games";
        $this->injector = $injector;
        $this->model = $model;
        
    }
    
    
    public function dashboard() 
    {
        return $this->view = "homepage/index";
    }
}

