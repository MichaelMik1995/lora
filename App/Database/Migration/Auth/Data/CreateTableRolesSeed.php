<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableRolesSeed 
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
    private $table = "roles";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Administrátor",
            "slug" => "admin",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Redaktor",
            "slug" => "editor",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Vývojář",
            "slug" => "developer",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

