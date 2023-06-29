<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerOrderController extends MshopController 
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
        if(isset($this->u["param"]))
        {
            $string = urldecode($this->u["param"]);
            $get_all = $this->model["order"]->searchOrder($string);
            $counter = count($get_all);
            
            $this->injector["LoraException"]->successMessage("Vyhledávání objednávky podle fráze: $string: Vyhledáno $counter záznamů");
        }
        else
        {
            $get_all = $this->model["order"]->getSolved();
        }
           
        $this->data = [
            "all" => $get_all,
        ];
        

        $this->view="manager/order/index";
    }
    
    public function orderFind()
    {
        $validation = $this->injector["Validation"];
        $search = $validation->input("searched-order-id");
        
        $validation->validate($search, ["required", "max_chars256"], "Hledaná fráze");
        
        if($validation->isValidated() == true)
        {
            $encode = urlencode($search);
            $this->redirect("mshop/manager/orders/$encode");
        }
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
        $this->view = "manager/order/show";
    }
    
    public function changeStatus()
    {
        $route_param = $this->u["param"];
        
        $validation = $this->injector["Validation"];
        $exception = $this->injector["LoraException"];
        
        $order_id = intval($validation->input("order_id"));
        $status = intval($validation->input("order_status"));
        $total_price = $validation->input("total_price");
        $email_to = $validation->input("email_to");

        $validation->validate($order_id, ["int", "required"]);
        $validation->validate($status, ["int1", "required"]);
        $validation->validate($email_to, ["email", "required"]);

        $ordered_products = $this->model["basket"]->getOrderProducts($route_param);
        
        if($validation->isValidated() == true)
        {
            try {
                $this->model["order"]->updateOrderStatus($order_id, $status, $ordered_products, $email_to, [
                    "{order-price}" => $total_price,
                    "{order-id}" => $order_id,
                    
                ]);

                $exception->successMessage("Změna byla provedena!");
            } catch (LoraException $ex) {
                $exception->errorMessage($ex->getMessage());

            }
            $this->redirect("mshop/manager/order-show/$order_id");

        }
    }
    
    public function orderIssue()
    {
        $order_id = $this->u["param"];
        
        //Subtract products
        $this->model["order"]->subtractOrderProductsQuantity($order_id);
        $this->model["order"]->issuedFromHouse(intval($order_id));
        
        $this->redirect("mshop/manager/order-show/$order_id");
    }
}

