<?php
declare(strict_types = 1);

namespace App\Database\Migration\Admin;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 19.01.2023 10:07:22
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Admin
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
            "Admin_cli_log",
            "Admin_hrefs",
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
        /* $factory->table = "role-id";
        $factory->foreignKey("this-id", "table-from", "id-from-table"); */ 
    }

    /**
     * Calling migrated data specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "Admin_hrefs",
        ];
    }
}