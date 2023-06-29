<?php
declare(strict_types = 1);

namespace App\Database\Migration\Documentation;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 02.06.2023 10:55:15
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Documentation
{

    /**
     * Call own migration sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own migrations (Example.: "Role_id => calling file CreateTableRole_id.php")
            "Documentation_categories",
            "Documentation_versions",
            "Documentation",
        ];
    }

    /**
     * Calling post migration callers?
     *
     * @param MigrationFactory $factory
     * @return void
     */
    public function postMigration(MigrationFactory $factory)
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
    public function callMigrateData()
    {
        return [
            "Documentation_categories",
            "Documentation_versions",
            "Documentation",
        ];
    }
}