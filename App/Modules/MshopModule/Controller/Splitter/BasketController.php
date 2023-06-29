<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
use App\Exception\LoraException;
//Module Model  


class BasketController extends MshopController 
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
    
    
    public function basket() 
    {
        $basket = $this->model["basket"];
        $view_page = "basket/";
        $ip = $_SERVER["REMOTE_ADDR"];
        
        @$order = $basket->getOrder($_SESSION[$ip]["ORDER_ID"]);
        if(@$order["solved"] == 0)
        {
            @$all = $basket->getOrderProducts($_SESSION[$ip]["ORDER_ID"]);
            @$price_summary = $basket->getOrderSuma($_SESSION[$ip]["ORDER_ID"]);
        }
        else
        {
            $all = [];
            $price_summary = null;
        }

        $this->data = [
            "number_utils" => $this->injector["NumberUtils"],
            "all" => $all,
            "order" => $order,
            "summary" => $price_summary,
        ];

        $this->title = "Košík";
        $this->view = $view_page."index";
    }
    
    public function addBasket()
    {
        $validation = $this->injector["Validation"];
        
        $logger = $this->model["logger"];
        $basket = $this->model["basket"];
        $exception = $this->injector["LoraException"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $product = $this->model["product"];
        
        
        if(!isset($_SESSION[$ip]))
        {
            $_SESSION[$ip]["ORDER_ID"] = rand(0000000,9999999);
            $_SESSION[$ip]["PRODUCTS"] = [];
            
            //Log Event
            $logger->log("New basket created for user with ip: $ip!", "create");
            
            //LOG Event
            $this->injector["Logger"]->log("New basket created for user with ip: $ip!", "SUCCESS:BASKET_CREATE");
        }
        else 
        {
            $get_order = $basket->getOrder($_SESSION[$ip]["ORDER_ID"]);

            if($get_order["solved"] == 1)
            {
                $_SESSION[$ip]["PRODUCTS"] = [];
                $_SESSION[$ip]["ORDER_ID"] = rand(0000000,9999999);
                $logger->log("New basket created for user with ip: $ip | reorder: ".$_SESSION[$ip]["ORDER_ID"]."!", "basket create");
                
                //LOG Event
                $this->injector["Logger"]->log("New basket created for user with ip: $ip | reorder: ".$_SESSION[$ip]["ORDER_ID"]."!", "SUCCESS:BASKET_CREATE");
            }                   

        }

        $order_id = intval($_SESSION[$ip]["ORDER_ID"]);
        $stock_code = $validation->input("stock_code");
        $quantity = intval($validation->input("quantity"));
        $size = $validation->input("size");
        
        echo $size;
        
        if(!isset($size))
        {
            $size = " ";
        }

        $get_one = $product->getProduct($stock_code);

        if($quantity <= $get_one["quantity"] || $quantity < 1)
        {
            if($basket->checkExistingOrder($order_id) == false)
            {
                try {
                    $basket->generateOrder($order_id);
                    $basket->addOrderProduct($order_id, $stock_code, $quantity, $size);

                    $exception->successMessage("Položka přidána!");
                    
                    //LOG Event
                    $logger->log("Adding product @product_code$stock_code@($quantity) to existing basket id: @orderid".$_SESSION[$ip]["ORDER_ID"]."@", "basket product add");

                } catch (LoraException $ex) {
                    $this->injector["logger"]->log($ex->getMessage());
                    $exception->errorMessage("Nepodařilo se přidat položku do košíku!");
                }
            }
            else
            {
                try {

                    $basket->addOrderProduct($order_id, $stock_code, $quantity, $size);
                    
                    //LOG Event
                    $this->injector["logger"]->log("Adding product $stock_code to ORDER ID: ".$_SESSION[$ip]["ORDER_ID"]."...", "SUCCESS:RECOUNT_BASKET");
                    $logger->log("Adding product @product_code$stock_code@($quantity) to existing basket id: @orderid".$_SESSION[$ip]["ORDER_ID"]."@", "basket product add");

                    $exception->successMessage("Položka přidána!");

                } catch (LoraException $ex) {
                    $this->injector["logger"]->log($ex->getMessage());
                    $exception->errorMessage("Nepodařilo se přidat položku do košíku!");
                }
            }

            $_SESSION[$ip]["PRODUCTS"][] = $stock_code;
        }
        else
        {
            //LOG Event
            $this->injector["logger"]->log("Order valuating reached maximum stock quantity: $quantity from ".$get_one["quantity"], "ERROR:ADD_BASKET");
            $exception->errorMessage("Objednané množství nesmí přesáhnout počet naskladněných kusů/párů atd.. $quantity z ".$get_one["quantity"]);
        }

        //add product to order

        $this->redirect("mshop/shop/basket");
    }
    
    public function removeFromBasket()
    {
        $validation = $this->injector["Validation"];
        $ip = $_SERVER["REMOTE_ADDR"];
        
        $product_code = $validation->input("product_code");
        $form_order_id = intval($validation->input("order_id"));

        $validation->validate($product_code, ["url", "required"]);
        $validation->validate($form_order_id, ["int", "required"]);

        if($validation->isValidated() == true)
        {
            if($_SESSION[$ip]["ORDER_ID"] == $form_order_id)
            {
                try {
                    $this->model["basket"]->deleteOrderProduct($form_order_id, $product_code);
                    $counter = count($_SESSION[$ip]["PRODUCTS"]);
                    for($i = 0; $i < $counter; $i++)
                    {
                        if($_SESSION[$ip]["PRODUCTS"][$i] == $product_code)
                        {
                            
                            //LOG Event
                            $this->injector["logger"]->log("Removing product $product_code from ORDER: $form_order_id ...", "SUCCESS:REMOVE_FROM_BASKET");
                            $this->model["logger"]->log("Removing product @product_code$product_code@ from basket id: @orderid".$_SESSION[$ip]["ORDER_ID"]."@", "basket product remove");

                            $_SESSION[$ip]["PRODUCTS"][$i] = -1;
                        }
                    }
                    
                    $this->injector["logger"]->log("Order: $form_order_id remove", "SUCCESS:REMOVE_FROM_BASKET");
                    $this->injector["LoraException"]->successMessage("Produkt byl smazán!");

                } catch (LoraException $ex) {
                    $this->injector["logger"]->log($ex->getMessage());
                    $this->injector["LoraException"]->errorMessage($ex->getMessage());
                }

                $this->redirect("mshop/shop/basket");
            }
            else
            {
                $this->injector["logger"]->log("BAD Request from $ip -> unauthorized order", "ERROR:REMOVE_FROM_BASKET");
                $this->injector["LoraException"]->errorMessage("Nelze měnit cizí objednávku!");
            }
        }
    }
    
    public function recountBasket()
    {
        $validation = $this->injector["Validation"];
        $ip = $_SERVER["REMOTE_ADDR"];
        
        //MiddleWare -> Validation
        $product_code = $validation->input("product_code");
        $form_order_id = intval($validation->input("order_id"));
        $quantity = intval($validation->input("product_new_quantity"));

        $validation->validate($product_code, ["url", "required"]);
        $validation->validate($form_order_id, ["int", "required"]);
        $validation->validate($quantity, ["int", "required"]);

        if($validation->isValidated() == true)
        {
            if($_SESSION[$ip]["ORDER_ID"] == $form_order_id)
            {
                //if product code exists
                $product = $this->model["order"]->getProductFromOrder($form_order_id, $product_code);
                
                //if quantity is validated
                if(!empty($product) || $product!=null)
                {
                    $max_product_quantity = $product["quantity"];
                    if(($quantity <= $max_product_quantity) && $quantity!=0)
                    {
                        
                        //update order row
                        try{
                            $this->injector["logger"]->log("Order: $form_order_id updated", "SUCCESS:RECOUNT_BASKET");
                            $this->model["order"]->updateOrderProduct($form_order_id, $product_code, $quantity);
                            $this->injector["LoraException"]->successMessage("Počet kusů byl úspěšně upraven!");

                        } catch (LoraException $ex) {
                            $this->injector["logger"]->log($ex->getMessage(), "ERROR:RECOUNT_BASKET");
                            $this->injector["LoraException"]->errorMessage($ex->getMessage());
                        }
                        
                        //Redirect HEADER
                        $this->redirect("mshop/shop/basket");
                    }
                    else
                    {
                        $this->injector["logger"]->log("Order valuating reached maximum stock quantity: $quantity from ".$product["quantity"], "ERROR:RECOUNT_BASKET");
                        $this->injector["LoraException"]->errorMessage("Maximální počet objednaných kusů nesmí přesáhnout $max_product_quantity!");
                    }
                }
                else
                {
                   $this->injector["logger"]->log("Ordered product: ".$product["product_code"]." not exists in ORDER: $form_order_id", "ERROR:RECOUNT_BASKET");
                   $this->injector["LoraException"]->errorMessage("Produkt neexistuje!"); 
                }
                //if both true -> change row

                //redirect to basket with new order details
            }
            else
            {
                $this->injector["logger"]->log("Change unathorized order! OWNER: $form_order_id | CUSTOMER: $ip", "ERROR:RECOUNT_BASKET");
                $this->injector["LoraException"]->errorMessage("Nelze měnit cizí objednávku!");
            }
        }
    }
}

