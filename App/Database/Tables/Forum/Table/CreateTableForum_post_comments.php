<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_post_comments 
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
    private $table = "forum-post-comments";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns    
        $title = $factory->createTableColumn("title", "varchar", 256);
            $author = $factory->createTableColumn("author", "int");
            $url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
            //Foreign key to forum-subcategories->id
            $post_url = $factory->createTableColumn("post_url", "varchar", 128);
            $content = $factory->createTableColumn("content", "varchar", 4096);
            $reply_to = $factory->createTableColumn("reply_to", "varchar", 512);
            $review = $factory->createTableColumn("review", "int", 1, default: "1");
            $great_comment = $factory->createTableColumn("great_comment", "int", 1, default: "0");
            $bad_comment = $factory->createTableColumn("bad_comment", "int", 1, default: "0");

        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $author,
            $url,
            $post_url,
            $content,
            $reply_to,
            $review,
            $great_comment,
            $bad_comment,
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

