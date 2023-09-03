<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentation_versions 
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
    private $table = "documentation_versions";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns
        $version = $factory->createTableColumn("version", "varchar", 65);
        $url = $factory->createTableColumn("url", "varchar", 65, special: "UNIQUE");
        $description = $factory->createTableColumn("description", "varchar", 512, 1);         
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $version,
            $url,
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

