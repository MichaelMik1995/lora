<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentation_categoriesSeed 
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
    private $table = "documentation_categories";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into documentation_categories ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Vítejte",
            "url" => "vitejte"
        ]);
        
        $factory->createSeed($this->table, [
            "title" => "O frameworku",
            "url" => "o-frameworku"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

