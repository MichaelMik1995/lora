<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;

//Module Model  


class MshopOrderController extends MshopController 
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
    
    
    public function order() 
    {
        $get_transports = $this->model["basket"]->getTransports();
        $ip = $_SERVER["REMOTE_ADDR"];  
        
        $this->data = [
            "transports" => $get_transports,
            "order" => $this->model["order"]->get($_SESSION[$ip]["ORDER_ID"]),
            "number_utils" => $this->injector["NumberUtils"],
            "summary" => $this->model["basket"]->getOrderSuma($_SESSION[$ip]["ORDER_ID"]),
            "states" => $this->model["state"]->getAll("name ASC"),
            "order_id" => $_SESSION[$ip]["ORDER_ID"],
        ];
        $this->view = "basket/order";
    }
    
    public function removeOrder()
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        
        try {
            $this->model["basket"]->deleteOrder($_SESSION[$ip]["ORDER_ID"]);
            $this->injector["LoraException"]->successMessage("Objednávka byla zrušena");
            $this->redirect("mshop");
        } catch (LoraException $ex) 
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
        }

    }
    
    public function orderUpdate()
    {
        $validation = $this->injector["Validation"];
        $ip = $this->model["ip"];
        
        $order_id = $validation->input("order_id");
                
        if($order_id == $_SESSION[$ip]["ORDER_ID"])
        {
            $name = $validation->input("given-name");
            $surname = $validation->input("family-name");
            $email = $validation->input("email");
            $phone = $validation->input("tel");
            $country = $validation->input("country");
            $address = $validation->input("street-address");
            $city = $validation->input("city");
            $post_code = $validation->input("postal-code");
            $transport = $validation->input("transport");
            $note = $validation->input("note");

            $validation->validate($name, ["required"]);
            $validation->validate($surname, ["required"]);
            $validation->validate($email, ["email","required"]);
            $validation->validate($phone, ["required"]);
            $validation->validate($country, ["required"]);
            $validation->validate($address, ["required"]);
            $validation->validate($city, ["required"]);
            $validation->validate($post_code, ["required"]);
            $validation->validate($transport, ["required"]);
            $validation->validate($note, ["maxchars512","string"]);
            
            $ordered_products = $this->model["basket"]->getOrderProducts($order_id);

            if($validation->isValidated() == true)
            {
                try {
                    $this->model["order"]->update([
                        "name" => $name,
                        "surname" => $surname,
                        "city" => $city,
                        "address" => $address,
                        "country" => $country,
                        "post_code" => $post_code,
                        "phone" => $phone,
                        "email" => $email,
                        "delivery_type" => $transport,
                        "note" => $note,

                    ], $order_id, $this->model["ip"]);
                    
                    

                    $this->injector["LoraException"]->successMessage("Objednávka upravena!");
                    $this->redirect("mshop/shop/order-summary");

                } catch (LoraException $ex) {
                    $this->injector["LoraException"]->errorMessage($ex->getMessage());
                    $this->redirect("mshop/shop/order");
                }
            }
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Nelze objednávat na cizí objednávkové číslo!");
            $this->redirect("mshop");
        }

        //check if user has this order

        //update data
    }
    
    public function orderSummary()
    {
        $validation = $this->injector["Validation"];
        $ip = $this->model["ip"];
        
         //$get_transports = $basket->getTransports();
        $get_order = $this->model["order"]->get($_SESSION[$ip]["ORDER_ID"]);
        $order_products = $this->model["basket"]->getOrderProducts($_SESSION[$ip]["ORDER_ID"]);
        $branches = $this->model["branch"]->getAll();

        $this->data = [
            "order_id" => $_SESSION[$ip]["ORDER_ID"],
            "summary" => $this->model["basket"]->getOrderSuma($_SESSION[$ip]["ORDER_ID"]),
            "number_utils" => $this->injector["NumberUtils"],
            "order" => $get_order,
            "products" => $order_products,
            "branches" => $branches,
                ];

        $this->view = "basket/order_summary";
    }
    
    public function writeOrder()
    {
        $validation = $this->injector["Validation"];
        
        $ip = $this->model["ip"];
        
        $order_id = $validation->input("order_id");
        
        
        $get_transports = $this->model["basket"]->getTransports();
        $get_order = $this->model["order"]->get($order_id);
        $ordered_products = $this->model["basket"]->getOrderProducts($order_id);
        
        
        if($order_id == @$_SESSION[$ip]["ORDER_ID"])
        {
            @$branch = $validation->input("branch");
            if($branch != "")
            {
                try {
                    $this->model["order"]->update(["delivery_param"=>"branch_".$branch], $order_id, $ip);
                } catch (LoraException $ex) {
                    $this->injector["LoraException"]->errorMessage($ex->getMessage());
                }
            }
            
            $this->model["order"]->createInvoice($get_transports, $get_order, $ordered_products);
            

            //Solved
            $this->model["order"]->update(["solved"=>"1"], $order_id, $ip);
            $this->model["order"]->updateOrderStatus(intval($order_id), 0, $ordered_products, $get_order["email"]);

            
            $_SESSION[$ip]["PRODUCTS"] = [];

            unset($_SESSION[$ip]);
            //send email with generated PDF


            //if user is logged -> save to his archive
            if($this->injector["Auth"]->isLogged() == true)
            {

            }

            $this->view = "basket/order_finish";
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Nelze měnit cizí objednávku!");
        }
    }
}

