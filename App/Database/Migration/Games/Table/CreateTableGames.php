<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableGames 
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
    private $table = "games";


    public function createOrUpdateTable($factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            $name = $factory->createTableColumn("name","varchar", 256);
            $slug = $factory->createTableColumn("slug", "varchar", 128, 1);
            $url = $factory->createTableColumn("url", "varchar", 64, special: "UNIQUE");
            //Foreign keyfor games-genres
            $genre = $factory->createTableColumn("genre_slug", "varchar", 128);
            $tags = $factory->createTableColumn("tags", "varchar", 2048, 1);
            $description = $factory->createTableColumn("description", "varchar", 4096, 1);
            $evaluation = $factory->createTableColumn("evaluation", "float", 2, '0.0');

                                       
            //Usefull for articles -> date of created / updated in timestamp
            $timestamp = $factory->timestamp();            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $name,
                $url,
                $slug,
                $genre,
                $tags,
                $description,
                $evaluation,
                $timestamp
                ]);

            //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

