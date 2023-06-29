<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;

/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableRoles
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
    private $table = "roles";


    public function createOrUpdateTable($factory)
    {

        $create_table = $factory->createTable($this->table); //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey(); //Creates primary key column (Defaul: "id")
        //insert your own columns
        $name = $factory->createTableColumn("name", "varchar", 65);
        $slug = $factory->createTableColumn("slug", "varchar", 65, special: "UNIQUE");
        $description = $factory->createTableColumn("description", "varchar", 256, 1);


        //Save a complete folded table:
        $factory->tableSave([
            $create_table,
            $column_id,
            //Own columns
            $name,
            $slug,
            $description,
        ]);

        //Adding post features (foreign keys etc)
    }

    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}