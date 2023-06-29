<?php
declare(strict_types = 1);

namespace App\Database\Migration\Forum;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 16.12.2022 12:02:41
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Forum
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
            "Forum_themes",
            "Forum_categories",
            "Forum_posts",
            "Forum_post_comments",
            "Forum_styles"
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
     * Calling migrated specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "Forum_themes",
            "Forum_categories",
            "Forum_posts",
            "Forum_styles"
        ];
    }
}