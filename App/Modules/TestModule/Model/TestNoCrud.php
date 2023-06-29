<?php
declare (strict_types=1);

namespace App\Modules\TestModule\Model;

use App\Core\Model;

class TestNoCrud extends Model
{

    private array|null $database_data;

    
    public function __construct(string $route_param = null) 
    {
        $this->init();
    }
    
    public function getDatabaseData(string $table): Array|Null
    {
        $db_query = $this->db->selectRow($table, "name=? AND id!=?", ["MichaelMik",0]);
        if($db_query)
        {
            return $this->database_data = $db_query;
        }
        else
        {
            return $this->database_data = NULL;
        }
    }

    public function __set($name, $value) {
        $this->database_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->database_data[$name])) {
            return $this->database_data[$name];
        }
        return null;
    }
    
}
?>

