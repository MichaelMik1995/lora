<?php
declare (strict_types=1);

namespace App\Modules\PhpinfoModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\PhpinfoModule\Model\Phpinfo;    


class PhpinfoController extends Controller 
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
     * @instance of main model: Phpinfo() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $phpinfo_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        $this->model = [
            "phpinfo" => new Phpinfo()
        ];
    }
    
    
    public function index() 
    {
      
    }
}

