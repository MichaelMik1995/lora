<?php
declare(strict_types = 1);

namespace App\Database\Tables\Announcements;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 17.07.2023 10:48:20
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Announcements
{

    /**
     * Call own database sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own databases (Example.: "Role_id => calling file CreateTableRole_id.php")
            "Announcements",
        ];
    }

    /**
     * Calling post database callers?
     *
     * @param DatabaseFactory $factory
     * @return void
     */
    public function postWritter(DatabaseFactory $factory)
    {
        // *  Example of addin foreign keys  * //
        /* $factory->table = "role-id";
        $factory->foreignKey("this-id", "table-from", "id-from-table"); */ 
    }

    /**
     * Calling migrated data specially for this caller
     * 
     * @return array<string>
     */
    public function callDatabaseData()
    {
        return [
            "Announcements",
        ];
    }
}