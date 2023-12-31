<?php
declare (strict_types=1);

namespace App\Modules\HomepageModule\Model;

use App\Core\Model;

class Homepage extends Model
{

    protected $table = "homepage";
    
    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        //$this->database->table = $this->table; //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table homepage</p>
     */
    public function getAll(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->tableAllData($order_by);
        if(!empty($db_query))
        {
            $returnArray = [];
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
     * Returns rows computed by $limit_per_page variable
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table test</p>
     */
    public function getAllByPage(int|string $page = 1, int $limit_per_page = 25, string $order_by = "id ASC"): Array
    {

        $computed_limit = (($page - 1)*$limit_per_page. ", " .$limit_per_page);

        $db_query = $this->database->tableAllData("id", $computed_limit);
        
        if(!empty($db_query))
        {
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $tags = $row["tags"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["_tags"] = ArrayUtils::charStringToArray($tags);
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
    public function get(string $route_key="url"): Array
    {
        $db_query = $this->database->tableRowByRoute();
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
    
    public function delete(string $route_key = "url")
    {
        // delete row
        return $this->database->tableDeleteByRoute($route_key);
    }
}
?>

