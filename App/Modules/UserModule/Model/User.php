<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

use App\Core\Model;
use App\Core\DI\DIContainer;

class User extends Model
{
    protected $table = "users";
    
    //__Parent Constructed
    public function __construct(DIContainer $container)  //Cannot add more arguments! DIContainer $container must be only one argument
    {
        //Initilize main model
        $this->init($container);

        $this->database->table = $this->table; //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table user</p>
     */
    public function getAll(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->tableAllData($order_by);
        if(!empty($db_query))
        {
            $return_array = [];
            $i = 0;
            
            foreach($db_query as $row)
            {
                $id = $i++;
                
                //Filter indexes from $row
                $return_array[$id] = array_filter($row, "is_string", ARRAY_FILTER_USE_KEY);
                
                //$content = $row["content"];
                
                //$return_array[$id]["_content"] = $this->easy_text->translateText($content);
            }
            
            return $return_array;
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
                $db_query[$id]["_tags"] = $this->container->get(ArrayUtils::class)::charStringToArray($tags);
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

