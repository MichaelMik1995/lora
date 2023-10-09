<?php
declare(strict_types = 1);

namespace App\Database\Tables\Test_data;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 09.10.2023 14:48:10
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Test_data
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
            "Test_data",
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
            "Test_data",
        ];
    }
}