<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_commentsSeed 
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
    private $table = "task-comments";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [        //insert into task_comments ($keys) VALUES ($values) -> create ROW
            "task_url" => "sample-task",
            "author" => "111111111",
            "content" => "První komentář od autora úkolu",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

