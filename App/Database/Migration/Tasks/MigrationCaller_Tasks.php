<?php
declare(strict_types = 1);

namespace App\Database\Migration\Tasks;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 16.12.2022 12:02:43
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Tasks
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
            "Task_project_categories",
            "Task_projects",
            "Task_categories",
            "Task_statuses",
            "Task_tasks",
            "Task_comments",
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
        
        $factory->table = "task-projects";
        $factory->foreignKey("category_url", "task-project-categories", "category_slug");

        //task to multiple
        $factory->table = "task-tasks";
        $factory->foreignKey("task_category_url", "task-categories", "url");    //to task category
        $factory->foreignKey("status", "task-statuses", "url");             //to task status
        $factory->foreignKey("project_url", "task-projects", "url");        //to project
        $factory->foreignKey("author", "users", "uid");                     //to author (!MUST Migrate Role FIRST!!)

        //Comment to task
        $factory->table = "task-comments";
        $factory->foreignKey("task_url", "task-tasks", "url");

        

    }

    /**
     * Calling migrated specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "Task_project_categories",
            "Task_projects",
            "Task_categories",
            "Task_statuses",
            "Task_tasks",
            "Task_comments",
        ];
    }
}