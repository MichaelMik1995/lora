<?php
declare (strict_types=1);

namespace App\Modules\HomepageModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\HomepageModule\Model\Homepage;    


class HomepageController extends Controller 
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
     * @instance of main model: Homepage() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $homepage_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        $this->model = [
            "homepage" => new Homepage()
        ];
    }
    
    
    public function index() 
    {
      
    }
}

