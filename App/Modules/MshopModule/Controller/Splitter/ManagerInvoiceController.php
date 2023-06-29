<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerInvoiceController extends MshopController 
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
    protected $model;

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    public function index() 
    {
      
    }
    
    public function templateShow()
    {
        $this->view = "manager/invoice/show_template";
    }
    
    public function show()
    {
        
        $route_param = $this->u["param"];
        
        
        $get_transports = $this->model["basket"]->getTransports();
        $get_order = $this->model["order"]->get($route_param);
        $ordered_products = $this->model["basket"]->getOrderProducts($route_param);

        $this->data = [
            "order_id" => $route_param,
            "transports" => $get_transports,
            "summary" => $this->model["basket"]->getOrderSuma($route_param),
            "number_utils" => $this->injector["NumberUtils"],
            "order" => $get_order,
            "products" => $ordered_products,
            "states" => $this->model["state"]->getAll("name ASC"),
                ];
        
       $this->view = "manager/invoice/show"; 
    }
    
    public function save()
    {
        $route_param = $this->u["param"];
        
        $get_transports = $this->model["basket"]->getTransports();
        $get_order = $this->model["order"]->get($route_param);
        $ordered_products = $this->model["basket"]->getOrderProducts($route_param);
        
         $this->data = [
            "order_id" => $route_param,
            "transports" => $get_transports,
            "summary" => $this->model["basket"]->getOrderSuma($route_param),
            "number_utils" => $this->injector["NumberUtils"],
            "order" => $get_order,
            "products" => $ordered_products,
            "states" => $this->model["state"]->getAll("name ASC"),
                ];
        
        $this->model["order"]->createInvoice($get_transports, $get_order, $ordered_products);
        
         //$this->view = "manager/invoice/show_template";
        
        $this->redirect("mshop/manager/order-show/$route_param");
    }
}

