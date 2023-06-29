<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Modules\MshopModule\Model\Mshop;
/**
 * Description of MshopInvoice module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopInvoice extends Mshop {

    protected $table = "mshop-invoices";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        $this->database->table = $this->table; //Uncheck if table name is not like controller name
        $this->database->route_key = "invoice_code";
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

    public function insert(array $values) {
        //create folder
        
        //generate invoice and put into folder
        
        
        $this->database->tableInsertByRoute($values);
    }

    public function update(array $set) {
        return $this->database->tableUpdateByRoute($set);
    }

    public function delete() {
        return $this->database->tableDeleteByRoute();
    }

}
