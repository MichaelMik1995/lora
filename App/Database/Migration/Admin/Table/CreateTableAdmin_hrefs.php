<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAdmin_hrefs 
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
    private string $table = "admin-hrefs";


    public function createOrUpdateTable($factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $href_name = $factory->createTableColumn("name", "varchar", 64);
            $href = $factory->createTableColumn("href", "varchar", 64);
            $icon = $factory->createTableColumn("icon", "varchar", 64);
        $notification = $factory->createTableColumn("notification", "int", 8, 0, "0");
                                                 
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                $href_name,
                $href,
                $icon,
                $notification,
                ]);

            //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

