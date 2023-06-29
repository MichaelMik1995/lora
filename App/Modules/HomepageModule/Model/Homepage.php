<?php
/**
 * Description of Module Model - Homepage:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\HomepageModule\Model;

use App\Core\Model;
use App\Middleware\Auth;

class Homepage extends Model
{
    protected $table = "homepage";
    
    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->db->route_param = $route_param;
        }
        
        //$this->database->route_key = "url";       //Uncheck if route key is different from "url"
        //$this->database->table = $this->table;    //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: "id ASC")</p>
     * @return Array <p>Returns all records from table</p>
     */
    public function getAll(string $order_by = "id ASC"): Array {
        $db_query = $this->db->tableAllData($order_by);
        if (!empty($db_query)) {
            $returnArray = [];
            $i = 0;
            foreach ($db_query as $row) {
                $id = $i++;
                
            }

            return $db_query;
        } else {
            return [];
        }
    }

    /**
     * @return Array <p>Return one row from table and store it in array, where $result["column"] = "column_value"</p>
     */
    public function get(): Array {
        $db_query = $this->db->tableRowByRoute();
        if (!empty($db_query)) {
            $content = $db_query["content"];

            $db_query["_content"] = $this->easy_text->translateText($content);

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
        return $this->db->tableInsertByRoute($values);
    }

    /**
     * @param array $values <p>Array values for update ["col"=>"value", ...]</p>
     * @return \PDO
     */
    public function update(array $values) {
        return $this->db->tableUpdateByRoute($values);
    }

    /**
     * @return \PDO
     */
    public function delete() {
        return $this->db->tableDeleteByRoute();
    }
}
?>