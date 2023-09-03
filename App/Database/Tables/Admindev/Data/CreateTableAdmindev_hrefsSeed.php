<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAdmindev_hrefsSeed 
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
    private $table = "admindev-hrefs";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Přehled",
            "href" => "dashboard",
            "icon" => "dashboard",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Konfigurace",
            "href" => "config",
            "icon" => "gears",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Pluginy",
            "href" => "plugins",
            "icon" => "puzzle-piece",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Moduly",
            "href" => "modules",
            "icon" => "box",
        ]);

        $factory->createSeed($this->table, [
            "name" => "PHP Cli",
            "href" => "phpclis",
            "icon" => "code",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Databáze",
            "href" => "database",
            "icon" => "database",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Utility",
            "href" => "utils",
            "icon" => "box",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Nastavení",
            "href" => "settings",
            "icon" => "cog",
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

