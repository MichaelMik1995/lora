<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableGame_genres 
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
    private $table = "game_genres";


    public function createOrUpdateTable($factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $title = $factory->createTableColumn("title", "varchar", 128);
            $slug = $factory->createTableColumn("slug", "varchar", 128, special: "UNIQUE");
            $description = $factory->createTableColumn("content", "varchar", 2048, 1);

                                       
            //Usefull for articles -> date of created / updated in timestamp
            $timestamp = $factory->timestamp();            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $title,
                $slug,
                $description,
                //$timestamp
                ]);

            //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

