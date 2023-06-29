<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ShopController extends MshopController 
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
    protected $main_model;
    protected $model;

    
    public function __construct($injector, $model)
    {
        parent::__construct($this->title, $injector);
        
        $this->module = "mshop";
        $this->injector = $injector;
        $this->model = $model;
        
    }
    
    
    public function index() 
    {
      
    }
    
    public function main()
    {
        $get_view_product = $this->model["product"]->getRandomProduct("RAND()");
        $get_newest = $this->model["product"]->getSortedLimit("created_at DESC", 12);


        $this->data = [
          "random_product" => $get_view_product,
            "newest" => $get_newest,
            "number_utils" => $this->injector["NumberUtils"],
            "ip" => $_SERVER["REMOTE_ADDR"],
            "advert" => $this->model["advert"]->getRandom(),
        ];

        $this->view = "shop/products/main";
    }
    
}

