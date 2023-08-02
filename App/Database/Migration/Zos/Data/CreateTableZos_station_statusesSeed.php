<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_station_statusesSeed 
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
    private $table = "zos-station-statuses";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Domov hledají",
            "slug" => "domov-hledaji",
            "description" => "Zvířátka, která právě teď hledají útulný domov"
        ]);

        $factory->createSeed($this->table, [
            "name" => "V léčení",
            "slug" => "v-leceni",
            "description" => "Ti, kteří se právě léčí"
        ]);

        $factory->createSeed($this->table, [
            "name" => "Našli domov",
            "slug" => "nasli-domov",
            "description" => "Zvířátka, která již našla spokojený život"
        ]);

        $factory->createSeed($this->table, [
            "name" => "Nezařazeno",
            "slug" => "nezarazeno",
            "description" => "Zvířátka, o kterých ještě nemáme informace"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

