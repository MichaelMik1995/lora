<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;

/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableRole_id
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
    private $table = "role-id";


    public function createOrUpdateTable(MigrationFactory $factory)
    {

        $create_table = $factory->createTable($this->table); //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey(); //Creates primary key column (Defaul: "id")
        //insert your own columns
        $user_uid = $factory->createTableColumn("user_uid", "int");
        $role_slug = $factory->createTableColumn("role_slug", "varchar", 65);

        //Save a complete folded table:
        $factory->tableSave([
            $create_table,
            $column_id,
            //Own columns
            $user_uid,
            $role_slug,

        ]);

        //Adding post features (foreign keys etc)
    }

    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}