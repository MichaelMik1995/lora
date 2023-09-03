<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_themes
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "forum-themes";

    public function createOrUpdateTable(DatabaseFactory $factory)
    {           
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $name = $factory->createTableColumn("name", "varchar", 128);
            $url = $factory->createTableColumn("url", "varchar", 128);
            $description = $factory->createTableColumn("content", "varchar", 2048, 1);
            $icon = $factory->createTableColumn("icon", "varchar", 64, 1, default: "fa fa-comments");
                                                
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $name,
                $url,
                $description,
                $icon
                ]);

            $factory->addIndex("url");

    }
    
    public function removeTable(DatabaseFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

