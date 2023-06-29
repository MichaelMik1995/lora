<?php
declare (strict_types=1);

namespace App\Modules\TestModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\TestModule\Model\Test;    
use App\Modules\TestModule\Model\TestNoCrud;


class TestController extends Controller 
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
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $test_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);

        $this->injector = $injector;
        $this->model = [
            "test" => new Test()
        ];
    }
    
    
    public function index(TestNoCrud $test) 
    {
        $test->getDatabaseData("users");
        echo $test->email;
    }
}

