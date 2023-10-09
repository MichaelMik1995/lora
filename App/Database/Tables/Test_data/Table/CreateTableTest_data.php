<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTest_data 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    /**
    * Table with chars (_) will be replaced to "-" (forum_table -> forum-table)
    * @var string $table
    */
    private $table = "test_data";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        

        //insert your own columns
        $param_string = $factory->createTableColumn("parameter_string", "varchar", 128);
        $param_int = $factory->createTableColumn("parameter_int", "int", 11);
        $param_bool = $factory->createTableColumn("parameter_bool", "5");                                    
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $param_string,
            $param_int,
            $param_bool
        ]);

        //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

