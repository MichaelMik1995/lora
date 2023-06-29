<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Modules\MshopModule\Model\Mshop;

/**
 * Description of product
 *
 * @author michaelmik
 */
class product extends Mshop
{
    //protected $database;
    
    /*public function __construct($injector) 
    {
        $this->database = $injector["Database"];
    }*/
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table mshop</p>
     */
    
    public function getSortedProducts(string $sort_action, string $sort_param, string $category = "")
    { 
        $limit = 300;
        if($sort_action == "sort")
        {
            if($sort_param == "cheapest")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "price ASC LIMIT $limit");
                    $header = "Nejlevnější produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getSorted("price ASC LIMIT $limit");
                    $header = "Nejlevnější produkty:";
                }
                
            }

            if($sort_param == "expensive")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "price DESC LIMIT $limit");
                    $header = "Nejdražší produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getSorted("price DESC LIMIT $limit");
                    $header = "Nejdražší produkty:";
                }
            }

            if($sort_param == "rating")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "evaluation DESC LIMIT $limit");
                    $header = "Nejlépe hodnocené produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getRated();
                    $header = "Nejlépe hodnocené produkty:";
                }
            }

            if($sort_param == "recommended")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "recommended DESC LIMIT $limit");
                    $header = "Doporučené produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getSorted("recommended DESC LIMIT $limit");
                    $header = "Doporučené produkty:";
                }
            }

            if($sort_param == "new")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "created_at DESC LIMIT $limit");
                    $header = "Nejnovější produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getSorted("created_at DESC LIMIT $limit");
                    $header = "Nejnovější produkty:";
                }
            }
            
            if($sort_param == "top-seller")
            {
                if($category != "")
                {
                    $get_products = $this->getSortedProductsByCategory($category, "buyed DESC LIMIT $limit");
                    $header = "Nejprodávánější produkty z kategorie:";
                }
                else
                {
                    $get_products = $this->getSorted("buyed DESC LIMIT $limit");
                    $header = "Nejprodávánější produkty:";
                }
            }
        }  
        
        return [$get_products, $header];
    }
    
    public function getAllProducts(string $order_by = "id ASC")
    {
        // Get all
        return $this->database->select("mshop-products", "id!=? ORDER BY $order_by", [0]);
    }
    
    public function getEarns(int $from = 0, int $to = 0): Float
    {
        $suma = 0;
        
        $select_all = $this->database->select("mshop-earning", "id!=?", [0]);
        
        foreach($select_all as $row)
        {
            $quantity = $row["quantity"];
            $price = $row["price"];
            
            $suma = $suma+($quantity*$price);
        }
        
        return $suma;
    }
    
    public function getUnvalidatedProducts($order_by = "id ASC")
    {
        $min_quantity = $this->config->var("MIN_PRODUCTS");
        return $this->database->select("mshop-products", "id!=? AND (visibility=? OR quantity<?) ORDER BY $order_by", [0, 0, $min_quantity]);
    }
    
    public function getValidatedProducts($order_by = "id ASC")
    {
        return $this->database->select("mshop-products", "id!=? AND status=1 ORDER BY $order_by", [0]);
    }
    
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function getProduct(string $product_code): Array
    {
        // Get one row
        $product = $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
        if(!empty($product))
        {
            
            $product["reviews"] = $this->database->select("mshop-product-evaluation", "product_code=? ORDER BY created_at DESC", [$product_code]);
            $product["disscussion"] = $this->database->select("mshop-product-discussion", "url=? ORDER BY created_at DESC", [$product_code]);
            
            
            $i = 0;
            foreach($product["disscussion"] as $comments)
            {
                $id = $i++;
                $get_id = $comments["id"];
                
                $product["disscussion"][$id]["comments"] = $this->database->select("mshop-product-discussion-comments", "disscussion_id=? ORDER BY created_at DESC", [$get_id]);
            }
            
            
            if(!empty($product['sizes']))
            {
                $sizes = ltrim($product['sizes'], "&"); 
                $size_row = explode("&", $sizes);

                $j = 0;
                
                $size_array = [];
                
                 foreach ($size_row as $size_line ) 
                 {
                     $count_id = $j++;

                     $id = rand(1111, 9999);
                     $line_explo = explode(":", $size_line);

                     $size_array[$count_id]["size_name"] = $line_explo[0];
                     $size_array[$count_id]["size_count"] = $line_explo[1];
                 }
                 
                 $product["_sizes"] = $size_array;
                 
            }
                     
                     
            return $product;
        }
        else
        {
            return [];
        }
    }
    
    public function getRandomProduct(string $order_by = "created_at DESC"): Array
    {
        // Get one row
        $db_query = $this->database->select("mshop-products", "id!=? AND visibility!=0 ORDER BY $order_by LIMIT 1", [0]);
        if(!empty($db_query))
        {
           return $db_query[0];
        }
        else
        {
            return [];
        }
        
    }
    
    public function getRated(int $limit = 25)
    {
        return $this->database->select("mshop-products", "id!=? AND visibility=1 ORDER BY evaluation DESC LIMIT $limit", [0]);
    }
    
    public function getSorted(string $column)
    {
        return $this->database->select("mshop-products", "id!=? AND visibility=1 ORDER BY $column", [0]);
    }
    
    public function getSortedLimit($order_by = "price DESC", $limit = 5)
    {
        return $this->database->select("mshop-products", "id!=? AND visibility=1 ORDER BY $order_by LIMIT $limit", [0]);
    }
    
    public function getProductsByCategory($sub_category, $limit = 100) 
    {
        return $this->database->select("mshop-products", "subcategory=? AND visibility=1 ORDER BY evaluation DESC LIMIT $limit", [$sub_category]);
    }
    
    public function getSortedProductsByCategory($sub_category, $sorted_by)
    {
        return $this->database->select("mshop-products", "subcategory=? AND visibility=1 ORDER BY $sorted_by", [$sub_category]);
    }
    
    public function insertProduct(array $values)
    {
        //upload product images
        
        return $this->database->insert("mshop-products", $values);
    }
    
    public function updateProduct(string $stock_code, array $set)
    {
        // update row
        return $this->database->update("mshop-products", $set, "stock_code=?", [$stock_code]);
    }
    
    public function productVisited(string $stock_code)
    {
        $select = $this->database->selectRow("mshop-products", "stock_code=?", [$stock_code]);
        if(!empty($select))
        {
            $actual_value = $select["visited"];
            $new_value = $actual_value+1;
            return $this->database->update("mshop-products", ["visited"=>$new_value], "stock_code=?", [$stock_code]);
        }
        else
        {
            return null;
        }
    }
    
    public function deleteProduct(string $stock_code)
    {
        $path_images = "./public/img/mshop/product/$stock_code/thumb";
        //unlink images
        foreach(glob($path_images."/*") as $thumb_image)
        {
            $full_res = str_replace("/thumb", "", $thumb_image);
            unlink($thumb_image);
            
            if(!is_dir($full_res))
            {
                unlink($full_res);
            }
            
            //delete folders
            rmdir("./public/img/mshop/product/$stock_code/thumb");
            rmdir("./public/img/mshop/product/$stock_code");
        }
        
        
        
        // delete row
        return $this->database->delete("mshop-products", "stock_code=?", [$stock_code]);
    }
}
