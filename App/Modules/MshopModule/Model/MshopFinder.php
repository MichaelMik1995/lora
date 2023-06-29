<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Core\Database\Database;
use App\Core\Model;
use App\Middleware\Auth;

/**
 * Description of MshopFinder module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopFinder extends Model {

    protected $table = "MshopFinder";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        //$this->database->table = $this->table; //Uncheck if table name is not like controller name
    }

    public function getAll(string $key_word) 
    {
        $pattern = '%' . $key_word . '%';
        
        return $this->database->p_query(
                "SELECT * FROM `mshop-products` "
                . "WHERE `product_name` LIKE :key_word OR short_description LIKE :key_word OR description LIKE :key_word OR subcategory LIKE :key_word ORDER BY product_name ASC", 
                [':key_word' => $pattern]);
    }

    public function get() {
        return $this->database->tableByRoute();
    }

    public function insert(array $values) {
        return $this->database->tableInsertByRoute($values);
    }

    public function update(array $set) {
        return $this->database->tableUpdateByRoute($set);
    }

    public function delete() {
        return $this->database->tableDeleteByRoute();
    }

}
