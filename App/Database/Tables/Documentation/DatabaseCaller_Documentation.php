<?php
declare(strict_types = 1);

namespace App\Database\Tables\Documentation;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 02.06.2023 10:55:15
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Documentation
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
            "Documentation_categories",
            "Documentation_versions",
            "Documentation",
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
        $factory->table = "documentation";
        $factory->foreignKey("category", "documentation-categories", "url");
        $factory->foreignKey("version", "documentation-versions", "url");
    }

    /**
     * Calling migrated data specially for this caller
     * 
     * @return array<string>
     */
    public function callDatabaseData()
    {
        return [
            "Documentation_categories",
            "Documentation_versions",
            "Documentation",
        ];
    }
}