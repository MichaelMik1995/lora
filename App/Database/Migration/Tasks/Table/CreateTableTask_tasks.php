<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_tasks 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "task-tasks";


    public function createOrUpdateTable(MigrationFactory $factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
                  
            $url = $factory->createTableColumn("url", "varchar", 128, special: "UNIQUE");
            $project_id = $factory->createTableColumn("project_url", "varchar", 32);
            $task_category = $factory->createTableColumn("task_category_url", "varchar", 32);
            $author = $factory->createTableColumn("author", "int");
            $task_for = $factory->createTableColumn("task_for", "varchar", 4096);
            $end_time = $factory->createTableColumn("end_time", "int", 11, 1);
            $tags = $factory->createTableColumn("tags", "varchar", 4096, 1);
            $priority = $factory->createTableColumn("priority", "int", default: "5");
            $content = $factory->createTableColumn("content", "text", 8192);
            $status = $factory->createTableColumn("status", "varchar", 32);
            
            //Usefull for articles -> date of created / updated in timestamp
            $timestamps = $factory->timestamp(); 

            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $author,
                $project_id,
                $task_category,
                $url,
                $task_for,
                $end_time,
                $tags,
                $content,
                $status,
                $priority,
                $timestamps
                ]);     
                
            $factory->addIndex("url");
    }
    
    public function removeTable(MigrationFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

