<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;
use App\Modules\MshopModule\Model\Mshop;

/**
 * Description of MshopEvaluation module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopEvaluation extends Mshop {

    protected $table = "mshop-product-evaluation";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }
        
        $this->database->table = $this->table; //Uncheck if table name is not like controller name
        $this->database->route_key = "id";
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
        
        $db_insert = $this->database->tableInsertByRoute($values);
            $eval_rate = $values["rank"];
            $product_code = $values["product_code"];
            
            $get_product = $this->database->selectRow("mshop-products", "stock_code=?", [$product_code]);
            if(!empty($get_product))
            {
                $current_eval = $get_product["evaluation"];
                $new_eval = ($eval_rate+$current_eval)/2;
                
                $this->database->update("mshop-products", ["evaluation"=>$new_eval], "stock_code=?", [$product_code]);
            }
            else
            {
                throw new \Exception("Nelze najít product!");
            }

    }

    public function update(array $set) {
        return $this->database->tableUpdateByRoute($set);
    }

    public function delete() {
        return $this->database->tableDeleteByRoute();
    }

}
