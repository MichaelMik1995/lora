<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

/**
 * Description of MshopState module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopState extends Mshop 
{

    protected $table = "mshop-state";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        $this->database->table = $this->table; //Uncheck if table name is not like controller name
    }

    public function getAll(string $order_by = "id ASC") {
        return $this->database->tableAllData($order_by);
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
