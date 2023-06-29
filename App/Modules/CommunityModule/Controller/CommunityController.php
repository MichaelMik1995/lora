<?php
declare (strict_types=1);

namespace App\Modules\CommunityModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\CommunityModule\Model\Community;    


class CommunityController extends Controller 
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
     * @instance of main model: Community() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $community_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        $this->model = [
            "community" => new Community()
        ];
    }
    
    
    public function index() 
    {
      
    }
    
    private function splitter(string $class_name, array $pages_array, string $title="Shop")
    {
        $this->title = $title;
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            $method = $pages_array[$page];
            
            $this->community_controll = new $class_name($this->injector, $this->model);
            $this->community_controll->u = $this->u;
            $this->community_controll->$method();
        }
    }
}

