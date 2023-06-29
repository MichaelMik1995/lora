<?php
declare(strict_types = 1);

namespace App\Database\Migration\Auth;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 16.12.2022 12:00:50
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Auth
{

    /**
     * Is call() method active?
     * @var bool
     */
    public bool $active = true;

    /**
     * Is post migration active?
     * @var bool
     */
    public bool $post_migration = true;

    /**
     * Is migrate data active?
     * @var bool
     */
    public bool $migrate_data = true;


    /**
     * Call own migration sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own migrations (Example.: "Role_id => calling file CreateTableRole_id.php")
            "Role_id",
            "Roles",
            "Users",
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
        $factory->table = "users";
        $factory->addIndex("uid");

        $factory->table = "roles";
        $factory->addIndex("slug");

        $factory->table = "role-id";
        $factory->foreignKey("role_slug", "roles", "slug");
        $factory->foreignKey("user_uid", "users", "uid");
        
    }

    /**
     * Calling migrated specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "Users",
            "Roles",
            "Role_id"
        ];
    }
}