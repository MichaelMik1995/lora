<?php
declare(strict_types = 1);

namespace App\Database\Tables\Auth;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 16.12.2022 12:00:50
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Auth
{

    /**
     * Is call() method active?
     * @var bool
     */
    public bool $active = true;

    /**
     * Is post database active?
     * @var bool
     */
    public bool $post_database = true;

    /**
     * Is migrate data active?
     * @var bool
     */
    public bool $migrate_data = true;


    /**
     * Call own database sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own databases (Example.: "Role_id => calling file CreateTableRole_id.php")
            "Role_id",
            "Roles",
            "Users",
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
    public function callDatabaseData()
    {
        return [
            "Users",
            "Roles",
            "Role_id"
        ];
    }
}