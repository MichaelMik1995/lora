<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_projectsSeed 
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
    private $table = "task-projects";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "project_name" => "New Project",
            "project_description" => "Sample of new project",
            "url" => "sample-project",
            "category_url" => "webova-aplikace",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

