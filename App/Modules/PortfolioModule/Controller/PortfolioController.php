<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\PortfolioModule\Model\Portfolio;
use App\Modules\PortfolioModule\Model\PortfolioComment;
use App\Modules\PortfolioModule\Model\PortfolioItem; 
use App\Modules\PortfolioModule\Model\PortfolioCategory; 
use App\Modules\PortfolioModule\Model\PortfolioReview;
use App\Modules\PortfolioModule\Model\PortfolioTypes;
use App\Core\Lib\Uploader;


class PortfolioController extends Controller 
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
     * @instance of main model: Portfolio() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;

    protected Uploader $uploader;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $portfolio_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        $this->model = [
            "portfolio" => new Portfolio(),
            "type" => new PortfolioTypes(),
            "category" => new PortfolioCategory(),
            "item" => new PortfolioItem(),
            "review" => new PortfolioReview(),
            "comment" => new PortfolioComment()
        ];

        $this->uploader = new Uploader;
    }
    
    
    public function index() 
    {
      
    }
    
    private function splitter(string $class_name, array $pages_array, string $title="Shop")
    {
        
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            $method = $pages_array[$page];
            
            
            $this->portfolio_controll = new $class_name($this->injector, $this->model);
            $this->portfolio_controll->u = $this->u;
            $this->portfolio_controll->$method();
            $this->title = $title;
        }
    }
}

