<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAdmin_hrefsSeed 
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
    private $table = "admin-hrefs";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Přehled",
            "href" => "dashboard",
            "icon" => "dashboard",
        ]);
        
        $factory->createSeed($this->table, [
            "name" => "Pagembler",
            "href" => "pagembler",
            "icon" => "file",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Uživatelé",
            "href" => "users",
            "icon" => "user",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Média",
            "href" => "media",
            "icon" => "photo-film",
        ]);

        $factory->createSeed($this->table, [
            "name" => "PHP Cli",
            "href" => "phpclis",
            "icon" => "code",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Ban IP",
            "href" => "bannedips",
            "icon" => "user-slash",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Logy",
            "href" => "logs",
            "icon" => "pen",
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

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

