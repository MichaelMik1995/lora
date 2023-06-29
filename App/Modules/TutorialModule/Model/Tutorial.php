<?php
/**
 * Description of Module Model - Tutorial:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\TutorialModule\Model;

use App\Core\Model;
use App\Core\Database\Database;
use App\Middleware\Auth;

class Tutorial extends Model
{
    protected $table = "tutorials";
    
    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }
        
        //$this->database->route_key = "url";       //Uncheck if route key is different from "url"
        $this->database->table = $this->table;    //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: "id ASC")</p>
     * @return Array <p>Returns all records from table</p>
     */
    public function getAll(string $order_by = "id ASC"): Array {
        $db_query = $this->database->tableAllData($order_by);
        if (!empty($db_query)) {
            $returnArray = [];
            $i = 0;
            foreach ($db_query as $row) {
                $id = $i++;
                $tags = $row["tags"];
                $explode_tags = explode(",", $tags);
                $final_tags = array_unique($explode_tags);
                $db_query[$id][":tags"] = $final_tags;
            }

            return $db_query;
        } else {
            return [];
        }
    }

    public function getTags($tutorials = null)
    {
        if($tutorials != null)
        {
            $get_tags = $tutorials;
        }
        else
        {
            $get_tags = $this->database->select("tutorials", "id!=?", [0]);
        }
        
        $return_tags = [];

        foreach($get_tags as $row)
        {
            $tag = $row["tags"];
            $one_tag = explode(",",$tag);
            $return_tags = array_merge($return_tags, $one_tag);
        }

        return array_unique($return_tags);
    }

    /**
     * @return Array <p>Return one row from table and store it in array, where $result["column"] = "column_value"</p>
     */
    public function get(): Array {
        $db_query = $this->database->tableRowByRoute();
        if (!empty($db_query)) {
            $content = $db_query["content"];

            $db_query["_content"] = $this->easy_text->translateText($content, "45%");

            $tags = $db_query["tags"];
                $explode_tags = explode(",", $tags);
                $final_tags = array_unique($explode_tags);
                $db_query[":tags"] = $final_tags;

            return $db_query;
        } else {
            return [];
        }
    }

    /**
     * @param array $values <p>Array values for insert ["col"=>"value", ...]</p>
     * @return \PDO
     */
    public function insert(array $values) {
        return $this->database->tableInsertByRoute($values);
    }

    /**
     * @param array $values <p>Array values for update ["col"=>"value", ...]</p>
     * @return \PDO
     */
    public function update(array $values) {
        return $this->database->tableUpdateByRoute($values);
    }

    /**
     * @return \PDO
     */
    public function delete() {
        return $this->database->tableDeleteByRoute();
    }
}
?>
