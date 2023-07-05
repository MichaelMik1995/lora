<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\Model;
use App\Core\DI\DIContainer;

class Admin extends Model
{
    protected $table = "admin";

    public $container;
    
    public function __construct(DIContainer $container, string $route_param = null) {
        $this->container = $container;
        $this->init($container);
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }
        
        //$this->database->route_key = "url";       //Uncheck if route key is different from "url"
        //$this->database->table = $this->table;    //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: "id ASC")</p>
     * @return array <p>Returns all records from table</p>
     */
    public function getAll(string $order_by = "id ASC"): Array {
        $db_query = $this->database->tableAllData($order_by);
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
     * @return array <p>Return one row from table and store it in array, where $result["column"] = "column_value"</p>
     */
    public function get(string|int $uid): Array {
        $this->database->route_param = $uid;
        $db_query = $this->database->tableRowByRoute();
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
