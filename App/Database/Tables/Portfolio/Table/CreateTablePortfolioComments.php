<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolioComments 
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
    private $table = "portfolio-comments";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
        $title = $factory->createTableColumn("title", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
        $portfolio_url = $factory->createTableColumn("portfolio_url", "varchar", 128);
        $author = $factory->createTableColumn("author", "varchar", 65, 1);
        $email = $factory->createTableColumn("email", "varchar", 128, 1);
        $content = $factory->createTableColumn("content", "varchar", 4096);

        //insert your own columns
                                       
        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();            
            
        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $title,
            $url,
            $portfolio_url,
            $author,
            $email,
            $content,
            $timestamp
        ]);

        $factory->addIndex("url");

        //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

