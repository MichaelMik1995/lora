<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_categories 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    private $table = "task-categories";

    public function createOrUpdateTable(DatabaseFactory $factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
                   
            $category = $factory->createTableColumn("category", "varchar", 128, 0);
            $url = $factory->createTableColumn("url", "varchar", 32, 0);
            $description = $factory->createTableColumn("description", "varchar", 1024, 1);
            
            //Usefull for articles -> date of created / updated in timestamp
            $timestamps = $factory->timestamp(); 
            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $category,
                $url,
                $description,
                $timestamps,
                ]);

        $factory->addIndex("url");
    }
    
    public function removeTable(DatabaseFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}

