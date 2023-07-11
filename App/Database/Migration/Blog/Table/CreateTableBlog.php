<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableBlog 
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
    private $table = "blog";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        
        //insert your own columns
        $blog_title = $factory->createTableColumn("blog_title", "varchar", 128);
        $blog_url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
        $blog_content = $factory->createTableColumn("blog_content", "varchar", 2048);

        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $blog_title,
            $blog_url,
            $blog_content,
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

