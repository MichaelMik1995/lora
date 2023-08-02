<?php
declare(strict_types = 1);

namespace App\Database\Migration\Webdata;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 09.06.2023 11:02:34
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Webdata
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
            "",
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
            "",
        ];
    }
}