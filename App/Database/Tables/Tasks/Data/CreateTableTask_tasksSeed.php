<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_tasksSeed 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;

    /**
     * Truncate table before creating new data?
     * @var bool $truncate_before_seed
     */
    public bool $truncate_before_seed = true;
    
    /**
     * Table for operation
     * @var string $table
     */
    private $table = "task-tasks";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "url" => "sample-task",
            "project_url" => "sample-project",
            "task_category_url" => "kod",
            "author" => "111111111",
            "task_for" => "222222222,111111111",
            "end_time" => time()+100000,
            "tags" => "kod,test,php",
            "content" => "Vytvořte PHP kód do třídy ClassTest()",
            "status" => "novy-ukol",
            "priority" => "1",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

