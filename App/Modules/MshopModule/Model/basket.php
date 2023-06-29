<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Modules\MshopModule\Model\Mshop;
/**
 * Description of basket
 *
 * @author michaelmik
 */
class basket extends Mshop
{
    protected $ip;
    
    public function __construct() 
    {
        $this->init();
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->deleteExpirated();
    }

    public function checkExistingOrder($order_id): Bool
    {
        $db_query = $this->database->selectRow("mshop-orders", "order_id=? AND ip_orderer=? AND solved=?", [$order_id, $this->ip, 0]);
        
        if(!empty($db_query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function generateOrder($order_id)
    {
        
        return $this->database->insert("mshop-orders", [
            "order_id"=>$order_id, 
            "ip_orderer"=> $this->ip, 
            "created_at"=>time(),
            "expirated_at" =>time()+86400, //expiry at day
        ]);
    }
    
    public function addOrderProduct($order_id, $stock_code, $quantity, $size)
    {
        return $this->database->insert("mshop-order-products", [
            "order_id"=>$order_id, 
            "product_code"=>$stock_code, 
            "quantity" => $quantity,
            "size" => $size,
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }
    
    public function getOrder($order_id)
    {
        return $this->database->selectRow("mshop-orders", "order_id=?", [$order_id]);
    }
    
    public function getOrderProducts($order_id)
    {
        $i = 0;
        $db_query = $this->database->select("mshop-order-products", "order_id=?", [$order_id]);     
        
        foreach($db_query as $row)
        {
            $id = $i++;
            $product_code = $row["product_code"];
            
            $product = $this->database->selectRow("mshop-products", "stock_code=?",[$product_code]);
            
            
            $description = $product["short_description"];
            $is_action = $product["is_action"];
            $product_quantity = $product["quantity"];
            $product_name = $product["product_name"];
            $tax = $product["tax"];
            
            if($is_action == 1)
            {
                $price = $product["action_prize"];
            }
            else
            {
                $price = $product["price"];
            }
            
            
            $db_query[$id]["description"] = $description;
            $db_query[$id]["price"] = $price;
            $db_query[$id]["product_quantity"] = $product_quantity;
            $db_query[$id]["product_name"] = $product_name;
            $db_query[$id]["tax"] = $tax;
            
            
            
        }
        
        return $db_query;
    }
    
    public function deleteOrder($order_id)
    {
        $this->deleteOrderProducts($order_id);
        unset($_SESSION[$this->ip]);
        unset($_SESSION[$this->ip]["PRODUCTS"]);
        $this->database->delete("mshop-orders", "order_id=?", [$order_id]);
        unset($_SESSION[$this->ip]);
        return true;
    }
    
    public function deleteOrderProduct($order_id, $stock_code)
    {
        return $this->database->delete("mshop-order-products", "order_id=? AND product_code=?", [$order_id, $stock_code]);
    }
    
    public function deleteOrderProducts($order_id)
    {
        return $this->database->delete("mshop-order-products", "order_id=?", [$order_id]);
    }
    
    public function getTransports(): Array
    {
        return $this->database->select("mshop-transport", "id!=?", [0]);
    }
    
    public function getOrderSuma($order_id): Float
    {
        $count = 0;
        
        $db_query = $this->database->select("mshop-order-products", "order_id=?", [$order_id]);
        if(!empty($db_query))
        {
            foreach($db_query as $row)
            {
                $product_code = $row["product_code"];
                $order_quantity = $row["quantity"];
                
                //select price of product (is_action)
                $select_product_row = $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
                if(!empty($select_product_row))
                {
                    if($select_product_row["is_action"] == 1)
                    {
                        $price = $select_product_row["action_prize"];
                    }
                    else
                    {
                        $price = $select_product_row["price"];
                    }
                    
                    $count = $count + ($order_quantity*$price);
                }
                else
                {
                    return 0;
                }
            }
            
            return $count;
        }
        else 
        {
            return 0;
        }
    }
    
    private function deleteExpirated()
    {
        
        $actual_time = time();
        
        //check if some orders with expirated time exists
        $db_query = $this->database->select("mshop-orders", "expirated_at<? && solved='0'", [$actual_time]);
        if(!empty($db_query))
        {
            foreach($db_query as $order)
            {
                $order_id = $order["order_id"]; //ids of orders with exirated time
                
                //delete order products
                $this->database->delete("mshop-order-products", "order_id=?", [$order_id]);
                
                //delete order
                $this->database->delete("mshop-orders", "order_id=?", [$order_id]);
            }
        }
    }
    
    /**
     * Check if this product is already at basket
     * @param type $new_product_code
     */
    private function checkBasket($new_product_code)
    {
        $_SESSION[$this->ip]["PRODUCTS"];
    }
}
