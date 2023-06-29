<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_projects 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "task-projects";

    public function createOrUpdateTable(MigrationFactory $factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
                        
            $project_name = $factory->createTableColumn("project_name", "varchar", 256, 0);
            $project_description = $factory->createTableColumn("project_description", "varchar", 2048, 1);
            $url = $factory->createTableColumn("url", "varchar", 32);
            $project_category = $factory->createTableColumn("category_url", "varchar", 128);

            //Usefull for articles -> date of created / updated in timestamp
            $timestamps = $factory->timestamp();            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $project_name,
                $url,
                $project_category,
                $project_description,
                $timestamps,
                ]);

        $factory->addIndex("url");

            
    }
    
    public function removeTable(MigrationFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

