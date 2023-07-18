<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAnnouncements 
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
    private $table = "announcements";


    public function createOrUpdateTable($factory): Void
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns
        $title = $factory->createTableColumn("title", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 128, special:"UNIQUE");
        $author = $factory->createTableColumn("author", "varchar", 10);
        $type = $factory->createTableColumn("type", "varchar", 12, 1);
        $target = $factory->createTableColumn("target", "varchar", "200", 1);
        $content = $factory->createTableColumn("content", "varchar", 4096);
                                       
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
            $type,
            $target,
            $content,
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

