<?php
declare(strict_types = 1);

namespace App\Database\Tables\Tasks;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 16.12.2022 12:02:43
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Tasks
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
            "Task_project_categories",
            "Task_projects",
            "Task_categories",
            "Task_statuses",
            "Task_tasks",
            "Task_comments",
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
    public function callDatabaseData()
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