<?php
declare(strict_types = 1);

namespace App\Database\Tables\Games;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 16.12.2022 18:52:12
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Games
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
            "Games",
            "Game_genres"
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
     * Calling migrated specially for this caller
     * 
     * @return array<string>
     */
    public function callDatabaseData()
    {
        return [
            "Games",
            "Game_genres"
        ];
    }
}