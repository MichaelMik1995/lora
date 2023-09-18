<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentor_categories 
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
    private $table = "documentor_categories";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns
        $title = $factory->createTableColumn("title", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 128, special:"UNIQUE");
        $folder = $factory->createTableColumn("folder", "varchar", 128, 1);
        $description = $factory->createTableColumn("description", "varchar", 1024, 1);
        
                                       
        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $title,
            $url,
            $folder,
            $description,
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
        $factory->addIndex("url");
        $factory->addIndex("folder");
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

