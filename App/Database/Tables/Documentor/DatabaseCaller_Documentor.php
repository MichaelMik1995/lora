<?php
declare(strict_types = 1);

namespace App\Database\Tables\Documentor;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 15.09.2023 10:37:09
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Documentor
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
            "Documentor_categories",
            "Documentor_sheets",
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

        $factory->table = "documentor-sheets";
        $factory->foreignKey("category_url", "documentor-categories", "url");

        $factory->table = "documentor-categories";
        $factory->foreignKey("folder", "documentor-categories", "url");
    }

    /**
     * Calling migrated data specially for this caller
     * 
     * @return array<string>
     */
    public function callDatabaseData()
    {
        return [
            "",
        ];
    }
}