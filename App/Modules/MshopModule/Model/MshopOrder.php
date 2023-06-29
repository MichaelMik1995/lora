<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Core\Model;
use App\Core\Lib\EmailSender;

use Spipu\Html2Pdf\Html2Pdf;

use Lora\Compiler\Compiler;

 
/**
 * Description of MshopOrder module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopOrder extends Model 
{

    protected $table = "mshop-orders";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        $this->database->route_key = "order_id";
        
        $this->database->table = $this->table; //Uncheck if table name is not like controller name
    }

    public function getAll(string $order_by = "id ASC") {
        return $this->database->tableAllData($order_by);
    }
    
    public function getProductFromOrder(int $order_id, string $product_code)
    {
        $db_query = $this->database->selectRow("mshop-order-products", "order_id=? AND product_code=?", [$order_id, $product_code]);
        if(!empty($db_query))
        {
            return $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
        }
        else
        {
            return null;
        }
    }
    
    public function getUnsolved()
    {
        return $this->database->select($this->table, "solved=? AND name!=''", [0]);
    }
    
    public function getUnfinished()
    {
        return $this->database->select($this->table, "status!=? AND status!=?", [2,3]);
    }
    
    public function getSolved()
    {
        return $this->database->select($this->table, "solved=? AND name!='' ORDER BY status ASC, id DESC LIMIT 40", [1]);
    }
    
    public function searchOrder(string $search_string): Array
    {
        return $this->database->select($this->table, "id!=? AND ("
                . "id LIKE '%$search_string%' OR "
                . "order_id LIKE '%$search_string%' OR "
                . "name LIKE '%$search_string%' OR "
                . "surname LIKE '%$search_string%' OR "
                . "city LIKE '%$search_string%' OR "
                . "address LIKE '%$search_string%' OR "
                . "country LIKE '%$search_string%' OR "
                . "post_code LIKE '%$search_string%' OR "
                . "phone LIKE '%$search_string%' OR "
                . "email LIKE '%$search_string%' OR "
                . "note LIKE '%$search_string%' "
                . ") ORDER BY created_at DESC"
                , [0]);
    }

    public function get($order_id) 
    {
        $db_query = $this->database->selectRow("mshop-orders", "order_id=?", [$order_id]);
        
        
        if($db_query["country"] != "")
            {
                 $state = $this->database->selectRow("mshop-state", "slug=?", [$db_query["country"]]);
                 $db_query["_country"] = $state["name"];
            }
            
            if($db_query["delivery_type"] != "")
            {
                $transport = $this->database->selectRow("mshop-transport", "slug=?", [$db_query["delivery_type"]]);
                $db_query["_delivery_type"] = $transport["type"];
                $db_query["delivery_price"] = $transport["cost"];
            }
            
        return $db_query;
    }

    public function insert(array $values) {
        return $this->database->tableInsertByRoute($values);
    }
    
    public function insertToUserArchive(int $order_id, array $values)
    {
        
    }

    public function update(array $set, $order_id, $ip) {
        return $this->database->update("mshop-orders", $set, "order_id=?", [$order_id]);
    }
    
    public function createInvoice($transport, $order, $products)
    {        
        $compiler = new Compiler();
        
        // Pruducts table
        
        $suma = 0;
        $product_table = "";
        
        
        $html2pdf = new Html2Pdf('P','A4','cs', true, 'UTF8', true);
        
        
        foreach ($products as $product) 
        {
            $suma = $suma + $product['price']*$product['quantity'];
            
            //Get template product table
            $get_content = file_get_contents("./App/Modules/MshopModule/resources/templates/invoice/invoice_products_table.php");
            
            $compile_products_table = $compiler->compile($get_content, [
                "{quantity}" => $product['quantity'],
                "{product-name}" => $product['product_name'],
                "{price}" => $this->number_utils->parseNumber($product['price']-($product['price']/100)*$product["tax"]),
                "{dph}" => $this->number_utils->parseNumber($product["tax"]),
                "{dph-root}" => $this->number_utils->parseNumber($product['price']-(($product['price']/100)*$product["tax"])),
                "{dph-price}" => $this->number_utils->parseNumber(($product['price']/100)*$product["tax"]),
                "{product-price-suma}" => $this->number_utils->parseNumber($product['price'])." x ".$product['quantity']." = ".$this->number_utils->parseNumber($product['price']*$product['quantity'])
            ]);
            
            $product_table .= $compile_products_table;     
        } 
        
        
        //Invoice Template
        $invoice_template = file_get_contents("./App/Modules/MshopModule/resources/templates/invoice/invoice.php");
        
        $invoice = $compiler->compile($invoice_template, [
            "{id}" => $order["id"],
            "{order-id}" => $order["order_id"],
            "{host}" => $this->config->var("WEB_ADDRESS"),
            "{order-created-at}" => DATE("d.m.Y H:i:s", $order['created_at']),
            "{company}" => $this->config->var("WEB_NAME"),
            "{delivery-type}" => $order['_delivery_type'],
            "{bank-account}" => "123456789/0100",
            "{customer-name}" => $order['name']." ".$order['surname'],
            "{customer-address}" => $order["address"],
            "{customer-post-code}" => $order["post_code"],
            "{customer-city}" => $order["city"],
            "{products-price}" => $this->number_utils->parseNumber($suma),
            "{delivery-price}" => $this->number_utils->parseNumber($order["delivery_price"]),
            "{total}" => $this->number_utils->parseNumber($suma+$order["delivery_price"]),
            "{products-table}" => $product_table,
        ]);
        

        $invoice_name = $order['id']."_".$order['order_id'];
        
        
        $css = "<link rel='stylesheet' href='".$this->config->var("WEB_ADDRESS")."/public/css/stylize.css'>";
        
        $invoice_path = "App/Modules/MshopModule/resources/invoices/$invoice_name";
        
        
        if(!is_dir("./".$invoice_path))
        {
            mkdir("./".$invoice_path);
        }
        
        $file = fopen(__DIR__ ."/../resources/invoices/$invoice_name/$invoice_name.html", "w");
        fwrite($file, "<html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width; initial-scale=1.0;'>$css</head><body>".$invoice."</body>");
        fclose($file);
        
        
        /*try {
            ob_clean();
            set_time_limit(60);
            $html2pdf->writeHTML($invoice);

            $html2pdf->output(__DIR__ ."/../resources/invoices/$invoice_name/$invoice_name.pdf", "F");
        
        } catch (Html2PdfException $ex) {
              $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }*/
        
        
        
    }
    
    public function sendOrderInfo(int $order_id, int $new_status, array $ordered_products, string $email_to, array $options = [])
    {
        
    }
    
    public function updateOrderStatus(int $order_id, int $new_status, array $ordered_products, string $email_to, array $options = [])
    {
        $email = new EmailSender();
        $compiler = new Compiler();
        
        $_options = $options;
        
        $this->database->update("mshop-orders",["status"=>$new_status],"order_id=?", [$order_id]);
        
        $email->template_path = "App/Modules/MshopModule/resources/templates/email";
        
        $order = $this->get($order_id);
        
        if($order["delivery_param"] != "")
        {
            $br = str_replace("branch_", "", $order["delivery_param"]);
            $branch = $this->database->selectRow("mshop-branch", "slug=?", [$br]);
        }
        else
        {
            $branch = "";
        }
        
        
        $product_table = "";
        $suma = 0;
        
        foreach ($ordered_products as $product) 
        {
            $suma = $suma + $product['price']*$product['quantity'];
            
            //Get template product table
            $get_content = file_get_contents("./App/Modules/MshopModule/resources/templates/invoice/invoice_products_table.php");
            
            //Invoice Template
            $invoice_template = file_get_contents("./App/Modules/MshopModule/resources/templates/invoice/invoice.php");
        
            $compile_products_table = $compiler->compile($get_content, [
                "{quantity}" => $product['quantity'],
                "{product-name}" => $product['product_name'],
                "{order-id}" => $order["order_id"],
                "{price}" => $this->number_utils->parseNumber($product['price']-($product['price']/100)*$product["tax"]),
                "{dph}" => $this->number_utils->parseNumber($product["tax"]),
                "{dph-root}" => $this->number_utils->parseNumber($product['price']-(($product['price']/100)*$product["tax"])),
                "{dph-price}" => $this->number_utils->parseNumber(($product['price']/100)*$product["tax"]),
                "{product-price-suma}" => $this->number_utils->parseNumber($product['price'])." x ".$product['quantity']." = ".$this->number_utils->parseNumber($product['price']*$product['quantity'])
            ]);
            
            $product_table .= $compile_products_table;     
        } 
        
        
        $invoice = $compiler->compile($invoice_template, [
            "{id}" => $order["id"],
            "{host}" => $this->config->var("WEB_ADDRESS"),
            "{order-id}" => $order["order_id"],
            "{order-created-at}" => DATE("d.m.Y H:i:s", $order['created_at']),
            "{company}" => $this->config->var("WEB_NAME"),
            "{delivery-type}" => $order['_delivery_type'],
            "{bank-account}" => "123456789/0100",
            "{customer-name}" => $order['name']." ".$order['surname'],
            "{customer-address}" => $order["address"],
            "{customer-post-code}" => $order["post_code"],
            "{customer-city}" => $order["city"],
            "{products-price}" => $this->number_utils->parseNumber($suma),
            "{delivery-price}" => $this->number_utils->parseNumber($order["delivery_price"]),
            "{total}" => $this->number_utils->parseNumber($suma+$order["delivery_price"]),
            "{products-table}" => $product_table,
        ]);
        
        $options_complete = array_merge($_options, [
            "{invoice}" => $invoice,
        ]);
        

        
        switch($new_status)
        {
            case 0:
                $email->send($email_to, "Informace k objednávce č.".$order['order_id'], "objednavka_mail", $options_complete);
                break;
            case 1: //Send informations
                match($order["delivery_type"]){
                    "platba-pri-prevzeti" => $email->send($email_to, "Informace k platbě", "dobirka", [
                        "{order-id}" => $order["order_id"],
                        "{suma}" => $this->number_utils->parseNumber($suma),
                        "{_suma}" => $this->number_utils->parseNumber($order['delivery_price']+$suma),
                        "{delivery-cost}" => $this->number_utils->parseNumber($order['delivery_price']),
                    ]),
                            
                    "platba-predem" => $email->send($email_to, "Informace k platbě", "platba_predem", [
                        "{id}" => $order['id'],
                        "{order-id}" => $order["order_id"],
                        "{suma}" => $this->number_utils->parseNumber($suma),
                        "{_suma}" => $this->number_utils->parseNumber($order['delivery_price']+$suma),
                        "{delivery-cost}" => $this->number_utils->parseNumber($order['delivery_price']),
                        "{address}" => $order["address"]." ".$order["post_code"]." ".$order["city"],
                    ]),
                            
                    "vyzvednuti-na-pobocce" => $email->send($email_to, "Informace k platbě", "pobocka", [
                        "{order-id}" => $order["order_id"],
                        "{suma}" => $this->number_utils->parseNumber($suma),
                        "{branch}" => $branch["address"]." - ".$branch["name"],
                    ]),
                };
                break;
            
            case 2: //Finalize order -> take product from stock \ recount
                $email->send($email_to, "Objednávka č. ".$order["order_id"]." je vyřízena", "finalize", [
                        "{date}" => DATE("d.m.Y H:i:s", $order["created_at"]),
                    ]);
                $this->updateStatistic($order_id);
                break;
            
            case 3: //Cancel order -> delete
                $email->send($email_to, "Objednávka č. ".$order["order_id"]." byla zrušena", "canceled", [
                        "{date}" => DATE("d.m.Y H:i:s", $order["created_at"]),
                        "{order-id}" => $order["order_id"],
                        "{email}" => $this->config->var("MAIL_FROM"),
                        "{phone}" => $this->config->var("PHONE")
                    ]);
                break;
        }
    }
    
    public function issuedFromHouse(int $order_id)
    {
        //Update issued
        $this->database->update($this->table, ["issued"=>"1"], "order_id=?", [$order_id]);
        
        //update sizes
        
        $order_products = $this->database->select("mshop-order-products", "order_id=?", [$order_id]);
        
        if(!empty($order_products))
        {
            foreach($order_products as $o_product)
            {
                //Get product code of each ordered product
                $product_code = $o_product["product_code"];
                
                //Get ordered product size
                $get_size = $o_product["size"];
                
                //select product from db
                $product = $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
                
                //get string of sizes (&43:10&XS:3)
                $sizes = $product["sizes"];
                
                //Left trim & - (43:10&XS:3)
                $sizes_trimmed = ltrim($sizes, "&");
                
                //Explode with & separator ({43:10, XS:3})
                $sizes_explo = explode("&", $sizes_trimmed);
                
                
                
                if(!empty($get_size))
                {
                    //Get ordered qunatity (2)
                    $quantity = $o_product["quantity"];
                    
                    //Create new VAR
                    $new_quantity = 0;
                    $old_quantity = $quantity;
                    $finded_size = "";
                    
                    foreach($sizes_explo as $sz)
                    {
                        
                        //if string_contains specific size (43 => 43:10)
                        if(str_contains($sz, $get_size))
                        {
                            //Explode this size ([43,10])
                            $get_size_explode = explode(":", $sz);
                            $finded_size = $get_size_explode[0];
                            
                            echo $finded_size;
                            
                            //Get count this size from product db
                            $size_count = $get_size_explode[1];
                            
                            $old_quantity = $size_count;
                            //Subtract ordered size 10-2 = 8
                            $new_quantity = $size_count-$quantity;
                        }
                    }
                    
                    //New substring for replace
                    $construct_new_size = $finded_size.":".$new_quantity;
                    
                    //Old substring to replace
                    $construct_old_size = $finded_size.":".$old_quantity;
                    
                    //Construct new sizes_string to db update -> mshop-products
                    $new_quantity_string = str_replace($construct_old_size, $construct_new_size, $sizes);
                    
                    
                    //update in DB
                    $this->database->update("mshop-products", ["sizes"=>$new_quantity_string], "stock_code=?", [$product_code]);
                }
                else
                {
                    return null;
                }
            }
        }
        else
        {
            return null;
        }
        
    }
    
    public function updateStatistic(int $order_id): Bool
    {
        //get order info 
        $orders = $this->database->select("mshop-order-products", "order_id=?", [$order_id]);
        
        foreach ($orders as $order)
        {
            $product_code = $order["product_code"];
            $quantity = $order["quantity"];
            
            $products = $this->database->select("mshop-products", "stock_code=?", [$product_code]);
            
            $product_price = 0;
            
            foreach($products as $product)
            {
                
                $is_action = $product["is_action"];
                $buyed = $product["buyed"];
                if($is_action == 1)
                {
                    $price = $product["action_prize"];
                }
                else
                {
                    $price = $product["price"];
                }
                
                $product_price = $price;
                
                $this->database->insert("mshop-earning", [
                    "product_code" => $product_code,
                    "quantity" => $quantity,
                    "price" => $product_price,
                    "created_at" => time(),    
                ]);
                
                $update_buyed = $buyed+$quantity;
                $this->database->update("mshop-products",["buyed"=>$update_buyed],"stock_code=?", [$product_code]);
                
            }
            
        }
        
        return true;
        
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
    
    public function subtractOrderProductsQuantity($order_id)
    {
        $db_query = $this->database->select("mshop-order-products", "order_id=?", [$order_id]);
        
        if(!empty($db_query))
        {
            //get codes ad quantity
            foreach($db_query as $row)
            {
                $product_code = $row["product_code"];
                $quantity = $row["quantity"];
                
                $this->subtractProductQuantity($product_code, $quantity);
            }
            return true;
        }
        else
        {
            return null;
        }
    }
    
    public function subtractProductQuantity(string $product_code, $ordered_quantity)
    {
        $db_query = $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
        
        if(!empty($db_query))
        {
            $product_quantity = $db_query["quantity"];
            $new_quantity = $product_quantity-$ordered_quantity;
            
            return $this->database->update("mshop-products", ["quantity"=>$new_quantity], "stock_code=?", [$product_code]);

        }
        else
        {
            return null;
        }
    }
    
    public function updateOrderProduct(int $order_id, string $product_code, int $quantity)
    {
        return $this->database->update("mshop-order-products", ["quantity"=>$quantity], "order_id=? AND product_code=?", [$order_id, $product_code]);
    }

}
