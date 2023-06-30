<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\UserModule\Model\User;   

use App\Core\Interface\ModuleInterface;


class UserController extends Controller implements ModuleInterface
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
     * @instance of main model: User() of this controller.
     */
    protected $model;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $user_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        $this->model = [
            "user" => new User()
        ];
    }
    
    
    public function index() 
    {
      
    }
}

