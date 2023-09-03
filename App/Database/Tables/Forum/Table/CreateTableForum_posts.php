<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_posts 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "forum-posts";

    public function createOrUpdateTable(DatabaseFactory $factory)
    {

            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $title = $factory->createTableColumn("title", "varchar", 256);
            $author = $factory->createTableColumn("author", "int");
            $url = $factory->createTableColumn("url", "varchar", 128, 0, special: "UNIQUE");
            //Foreign key to forum-subcategories->id
            $subcategory_id = $factory->createTableColumn("category_url", "varchar", 128);
            $content = $factory->createTableColumn("content", "varchar", 4096);
            $solved = $factory->createTableColumn("solved", "int", 1, 1, default: "0");

                                       
            //Usefull for articles -> date of created / updated in timestamp
            $timestamps = $factory->timestamp();
            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $title,
                $author,
                $url,
                $subcategory_id,
                $content,
                $solved,
                $timestamps
                ]);

            $factory->addIndex("url");
    }
    
    public function removeTable(DatabaseFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

