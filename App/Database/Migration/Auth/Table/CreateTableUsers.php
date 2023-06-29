<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;

/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableUsers
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
    private $table = "users";


    public function createOrUpdateTable($factory)
    {
        
        $create_table = $factory->createTable($this->table); //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey(); //Creates primary key column (Defaul: "id")
        //insert your own columns
        $uid = $factory->createTableColumn("uid", "int");
        $name = $factory->createTableColumn("name", "varchar", 65);
        $real_name = $factory->createTableColumn("real_name", "varchar", 128, 1);
        $surname = $factory->createTableColumn("surname", "varchar", 128, 1);
        $gender = $factory->createTableColumn("gender", "varchar", 16, 1);
        $color = $factory->createTableColumn("color", "varchar", 16, 1, "18191d");
        $sec_color = $factory->createTableColumn("second_color", "varchar", 16, 1, "bfbfbf");
        $email = $factory->createTableColumn("email", "varchar", 65);
        $verify_code = $factory->createTableColumn("verify_code", "varchar");
        $email_verified_at = $factory->createTableColumn("email_verified_at", "int", default: "0");
        $password = $factory->createTableColumn("password", "varchar", 61);
        $registration_date = $factory->createTableColumn("registration_date", "int");
        $last_login = $factory->createTableColumn("last_login", "int");
        $status = $factory->createTableColumn("status", "int", 1, default: "0");
        $hidden = $factory->createTableColumn("hidden", "int", 1, default: "0");
        $session_key = $factory->createTableColumn("session_key", "varchar", 128, 1);

        //Save a complete folded table:
        $factory->tableSave([
            $create_table,
            $column_id,
            //Own columns
            $uid,
            $name,
            $real_name,
            $surname,
            $gender,
            $color,
            $sec_color,
            $email,
            $verify_code,
            $email_verified_at,
            $password,
            $registration_date,
            $last_login,
            $status,
            $hidden,
            $session_key,
        ]);


        //Adding post features (foreign keys etc)
    }

    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}