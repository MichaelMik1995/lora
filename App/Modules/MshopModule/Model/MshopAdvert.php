<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Model;
use App\Core\Model;

/**
 * Description of MshopAdvert module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopAdvert extends Model {

    protected $table = "mshop-advert";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }
        
        $this->database->route_key = "id";
        $this->database->table = $this->table; //Uncheck if table name is not like controller name
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
                $content = $row["content"];

                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
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
        $db_query = $this->database->tableByRoute();
        if (!empty($db_query)) {
            $content = $db_query["content"];

            $db_query["_content"] = $this->easy_text->translateText($content);

            return $db_query;
        } else {
            return [];
        }
    }

    public function getRandom()
    {
        $db_query = $this->database->selectRow($this->table, "id!=? ORDER BY RAND() LIMIT 1", [0]);
        if (!empty($db_query)) {
            $content = $db_query["content"];

            $db_query["_content"] = $this->easy_text->translateText($content);

            return $db_query;
        } else {
            return [];
        }
    }
    
    public function insert(array $values) {
        return $this->database->tableInsertByRoute($values);
    }

    public function update(array $set, $id) {
        return $this->database->update($this->table, $set, "id=?", [$id]);
    }

    public function delete($id) {
        return $this->database->delete($this->table, "id=?", [$id]);
    }

}
