<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_project_categoriesSeed 
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
    private $table = "task_project_categories";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "category_name" => "Webová aplikace",
            "category_slug" => "webova-aplikace",
        ]);

        $factory->createSeed($this->table, [
            "category_name" => "Hra",
            "category_slug" => "hra",
        ]);

        $factory->createSeed($this->table, [
            "category_name" => "Grafika",
            "category_slug" => "grafika",
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

