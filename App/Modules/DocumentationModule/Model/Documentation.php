<?php
declare (strict_types=1);

namespace App\Modules\DocumentationModule\Model;

use App\Core\Lib\Utils\StringUtils;
use App\Core\DI\DIContainer;
use App\Core\Database\Database;
use Lora\Easytext\Easytext;

class Documentation
{

    protected $table = "documentation";
    protected $table_categories = "documentation-categories";
    protected $table_versions = "documentation-versions";

    protected Database $database;
    protected Easytext $easy_text;
    
    public function __construct(DIContainer $container) 
    {
        $this->database = $container->get(Database::class);
        $this->database->table = $this->table; //Uncheck if table name is not like controller name
        $this->easy_text = $container->get(Easytext::class);
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table documentation</p>
     */
    public function getAll(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->table_categories, "id!=? ORDER BY $order_by", [0]);
        
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                
                $category_url = $row["url"];
                
                $db_query[$id]["sheets"] = $this->getSheetsByCategory($category_url);
            }
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table documentation</p>
     */
    public function getSheetsByCategory(string $category_url, string $order_by = "title ASC"): Array
    {
        $db_query = $this->database->select($this->table, "category=? ORDER BY $order_by", [$category_url]);
        
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                
                $content = $row["content"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
            }
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function get(string $url, string $route_key="url"): Array
    {
        
        $db_query = $this->database->selectRow("documentation", "url=?", [$url]);


        if(!empty($db_query))
        {
            $content = $db_query["content"];
            
            $db_query["_content"] = $this->easy_text->translateText($content);
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    /**
     * 
     * @param array $post
     * @param string $new_url
     * @param StringUtils $string_utils
     * @return void
     */
    public function insert(array $post, string $new_url, StringUtils $string_utils)
    {
        // Insert new row
        
        //check, if add-version blank
        if($post["add-version"] != "")
        {
            $version = $post["add-version"];
            $version_url = $string_utils->toSlug($version);
            $this->database->insert($this->table_versions, ["version" => $version, "url" => $version_url]);
        }
        else
        {
            $version = $post["version"];
            $version_url = $string_utils->toSlug($version);
        }
        
        //check, if add-category blank
        if($post["add-category"] != "")
        {
            $category = $post["add-category"];
            $category_url = $string_utils->toSlug($category);
            $this->database->insert($this->table_categories, ["title" => $category, "url" => $category_url]);
        }
        else
        {
            $category = $post["category"];
            $category_url = $string_utils->toSlug($category);
        }
        
        
        return $this->database->tableInsert($this->table, [
            "title" => $post["title"],
            "url" => $new_url,
            "version" => $version_url,
            "category" => $category_url,
            "content" => $post["content"],
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }
    
    public function update(array $post, StringUtils $string_utils)
    {
        // Insert new row
        
        //check, if add-version blank
        if($post["add-version"] != "")
        {
            $version = $post["add-version"];
            $version_url = $string_utils->toSlug($version);
            $this->database->insert($this->table_versions, ["version" => $version, "url" => $version_url]);
        }
        else
        {
            $version = $post["version"];
            $version_url = $string_utils->toSlug($version);
        }
        
        //check, if add-category blank
        if($post["add-category"] != "")
        {
            $category = $post["add-category"];
            $category_url = $string_utils->toSlug($category);
            $this->database->insert($this->table_categories, ["title" => $category, "url" => $category_url]);
        }
        else
        {
            $category = $post["category"];
            $category_url = $string_utils->toSlug($category);
        }
        
        
        return $this->database->update($this->table, [
            "title" => $post["title"],
            "version" => $version_url,
            "category" => $category_url,
            "content" => $post["content"],
            "created_at" => time(),
            "updated_at" => time(),
        ], "url=?", [$post['url']]);
    }
    
    public function delete(string $url)
    {
        // delete row
        return $this->database->delete($this->table, "url=?", [$url]);
    }
    
    public function getVersions()
    {
        return $this->database->select($this->table_versions, "id!=? ORDER BY version DESC", [0]);
    }
    
    public function getCategories()
    {
        return $this->database->select($this->table_categories, "id!=? ORDER BY title DESC", [0]);
    }
}
?>

