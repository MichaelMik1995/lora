<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentation_versionsSeed 
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
    private $table = "documentation_versions";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into documentation_versions ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "version" => "1.0",
            "url" => "1-0",
            "description" => "Verze 1.0 - Kostra aplikace"
        ]);
        
        $factory->createSeed($this->table, [
            "version" => "1.2",
            "url" => "1-2",
            "description" => "Verze 1.2 - Moduly"
        ]);
        
        $factory->createSeed($this->table, [
            "version" => "3.2",
            "url" => "3-2",
            "description" => "Verze 3.2 - Policy"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

