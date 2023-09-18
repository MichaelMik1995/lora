<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentor_sheets 
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
    private $table = "documentor_sheets";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        

        //insert your own columns
        $title = $factory->createTableColumn("title", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 128, special:"UNIQUE");
        $category = $factory->createTableColumn("category_url", "varchar", 128);
        $content = $factory->createTableColumn("content", "varchar", 9999, 1);
                                       
        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $title,
            $url,
            $category,
            $content,
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
        $factory->addIndex("url");
        $factory->addIndex("category_url");
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

