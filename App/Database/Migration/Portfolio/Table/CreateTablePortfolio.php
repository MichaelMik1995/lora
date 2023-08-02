<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolio 
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
    private $table = "portfolio";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns
        $title = $factory->createTableColumn("title", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
        $category_url = $factory->createTableColumn("category_url", "varchar", 128);
        $author = $factory->createTableColumn("author", "varchar", 65, 1);
        $short_description = $factory->createTableColumn("short_description", "varchar", 256);
        $content = $factory->createTableColumn("content", "varchar", 4096);
        $web_url = $factory->createTableColumn("web_url", "varchar", 1024, 1);
        $evaluation = $factory->createTableColumn("evaluation", "float", 2, default: "0");    
        $publish = $factory->createTableColumn("publish", "int", 1, 0, default: "0");

        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $title,
            $url,
            $author,
            $category_url,
            $short_description,
            $content,
            $web_url,
            $evaluation,
            $publish,
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
        $factory->addIndex("url");
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

