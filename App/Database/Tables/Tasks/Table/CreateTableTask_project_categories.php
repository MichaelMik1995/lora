<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;

/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_project_categories
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;

    private $table = "task-project-categories";

    public function createOrUpdateTable(DatabaseFactory $factory)
    {

        $create_table = $factory->createTable($this->table); //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey(); //Creates primary key column (Defaul: "id")
        //insert your own columns

        $category_name = $factory->createTableColumn("category_name", "varchar", 65, 0);
        $category_slug = $factory->createTableColumn("category_slug", "varchar", 65, special: "UNIQUE");


        //Save a complete folded table:
        $factory->tableSave([
            $create_table,
            $column_id,
            //Own columns
            $category_name,
            $category_slug,
        ]);
        
        $factory->addIndex("category_slug");
    }

    public function removeTable(DatabaseFactory $factory)
    {
        return $factory->removeTable($this->table);
    }
}