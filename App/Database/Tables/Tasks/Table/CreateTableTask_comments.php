<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_comments 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "task-comments";

    public function createOrUpdateTable(DatabaseFactory $factory)
    {            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
            
            $task_id = $factory->createTableColumn("task_url", "varchar", 128, 0);
            
            $author = $factory->createTableColumn("author", "int", 11, 0);
            $content = $factory->createTableColumn("content", "varchar", 4096, 0);

            //Usefull for articles -> date of created / updated in timestamp
            $timestamps = $factory->timestamp(); 
            
            
            //Save a complete folded table:
            return $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $task_id,
                $author,
                $content,
                $timestamps,
                ]);
    }
    
    public function removeTable(DatabaseFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

