<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_categories 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;

    private $table = "forum-categories";

    public function createOrUpdateTable(MigrationFactory $factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $name = $factory->createTableColumn("name", "varchar", 128);
            $url = $factory->createTableColumn("url", "varchar", 128, 0, special: "UNIQUE");

            //Foreign key to forum-themes->id
            $theme_id = $factory->createTableColumn("theme_url", "varchar", 128);
            $description = $factory->createTableColumn("content", "varchar", 2048, 1);
            $icon = $factory->createTableColumn("icon", "varchar", 64, 1, default: "fa fa-bullhorn");
                                                
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $name,
                $url,
                $theme_id,
                $description,
                $icon,
                ]);
            $factory->addIndex("url");
    }
    
    public function removeTable(MigrationFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

