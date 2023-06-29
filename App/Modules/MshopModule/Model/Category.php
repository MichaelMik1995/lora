<?php
namespace App\Modules\MshopModule\Model;

class Category extends Mshop
{
    protected $table = "mshop-category";
    
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table category</p>
     */
    public function getAll(string $order_by = "category_slug ASC")
    {
        // Get all
        $i = 0;
        $db_query = $this->database->select($this->table, "id!=? ORDER BY $order_by", [0]);
        
        foreach ($db_query as $row)
        {
            $id = $i++;
            
            $slug = $row["category_slug"];
            $db_query[$id]["subcategories"] = $this->database->select("mshop-subcategory" , "category_id=?", [$slug]);
            $db_query[$id]["subcategories_count"] = count($db_query[$id]["subcategories"]);
            
            $x = 0;
            
            foreach($db_query[$id]["subcategories"] as $sub)
            {
                $xid = $x++;
                
                
                $get_sub_slug = $sub["subcategory_slug"];
                
                $subcategories_product = $this->database->countRows("mshop-products", "subcategory=? AND visibility=?", [$get_sub_slug, 1]);
                $db_query[$id]["subcategories"][$xid]["count"] = $subcategories_product;
            }
        }
        
        return $db_query;
    }
    
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function get(string $route_key="url")
    {
        // Get one row
        return $this->database->tableRowByRoute($route_key);
    }
    
    public function getSubcategoryRealName(string $slug)
    {
        $db_query = $this->database->selectRow("mshop-subcategory", "subcategory_slug=?", [$slug]);
        if(!empty($db_query))
        {
            return $db_query["subcategory_name"];
        }
        else
        {
            return "unknown";
        }
    }
    
    public function insert(array $insert_values)
    {
        // Insert new row
        return $this->database->tableInsert($this->table, $insert_values);
    }
    
    public function update(array $set, string $route_key = "url")
    {
        // update row
        return $this->database->tableUpdateByRoute($set, $route_key);
    }
    
    public function deleteCategory(string $category_slug)
    {
        //set products to uncategorized
        echo $category_slug;
        $subcat = $this->database->selectRow("mshop-category", "category_slug=?", [$category_slug]);
        $this->setProductsUncategorized($subcat["category_slug"]);
        
        
        //delete subcategories
        //$db_query = $this->database->delete("");
        
        // delete row
        return $this->database->delete("mshop-category", "category_slug=?", [$category_slug]);
    }
    
    /* SUBCATEGORY */
    
    public function addSub($sub_name, $sub_slug, $category)
    {
        return $this->database->insert("mshop-subcategory", [
            "subcategory_name" => $sub_name,
            "subcategory_slug" => $sub_slug,
            "category_id" => $category,
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }
    
    public function deleteSub($sub_slug)
    {
        return $this->database->delete("mshop-subcategory", "subcategory_slug=?", [$sub_slug]);
    }
    
    private function setProductsUncategorized(string $subcategory)
    {
        return $this->database->update("mshop-products", ["category"=>"nocategory"], "category=?", [$subcategory]);
    }
}
