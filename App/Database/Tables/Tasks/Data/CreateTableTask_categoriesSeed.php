<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_categoriesSeed 
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
    private $table = "task_categories";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [ 
            "category" => "Grafika",
            "url" => "grafika",
            "description" => "Grafický úkol",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [ 
            "category" => "Kód",
            "url" => "kod",
            "description" => "Programovací kod",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [ 
            "category" => "HTML + CSS",
            "url" => "htmlacss",
            "description" => "Design a kostra webu",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

