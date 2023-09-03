<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_statuses 
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
    private $table = "task-statuses";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        $name = $factory->createTableColumn("name", "varchar", 65);
        $url = $factory->createTableColumn("url", "varchar", 32);
        $color = $factory->createTableColumn("color", "varchar", 10, default: "green");
        $icon = $factory->createTableColumn("icon", "varchar", 40, default: "box");
        $description = $factory->createTableColumn("description", "varchar", 256, 1);
        
        //insert your own columns           
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            //Own columns
            $name,
            $url,
            $color,
            $icon,
            $description,
        ]);

        //Adding post features (foreign keys etc)
        $factory->addIndex("url");
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

