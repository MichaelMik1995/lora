<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_station_animalsSeed 
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
    private $table = "zos-station-animals";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [        //insert into zos_station_animals ($keys) VALUES ($values) -> create ROW
            "name" => "Syndy",
            "url" => "syndy",
            "author" => "111111111",
            "status" => "domov-hledaji",
            "content" => "Syndy nyní hledá domov, kdo si jí vezme a zařídí jí krásný život v teple domova?",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

