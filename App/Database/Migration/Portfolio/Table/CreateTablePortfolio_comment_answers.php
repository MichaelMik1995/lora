<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolio_comment_answers 
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
    private $table = "portfolio-comment-answers";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        $url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
        $comment_url = $factory->createTableColumn("comment_url", "varchar", 128);
        $author = $factory->createTableColumn("author", "varchar", 65, 1);
        //$email = $factory->createTableColumn("email", "varchar", 128, 1);
        $content = $factory->createTableColumn("content", "varchar", 4096);

        //insert your own columns
                                       
        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            $url,
            $comment_url,
            $author,
            $content,
            //Own columns
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

