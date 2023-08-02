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
            "name" => "Uživatelé",
            "href" => "users",
            "icon" => "user",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Oznámení",
            "href" => "announcements",
            "icon" => "bullhorn",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Média",
            "href" => "media",
            "icon" => "photo-film",
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
            "name" => "Discord",
            "href" => "discord",
            "icon" => "discord",
        ]);
        
        $factory->createSeed($this->table, [
            "name" => "Utility",
            "href" => "utils",
            "icon" => "box",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Plánovač",
            "href" => "scheduler",
            "icon" => "calendar",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

