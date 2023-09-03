<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
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
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Přehled",
            "href" => "dashboard",
            "icon" => "fa fa-dashboard",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Uživatelé",
            "href" => "users",
            "icon" => "fa fa-user",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Oznámení",
            "href" => "announcements",
            "icon" => "fa fa-bullhorn",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Média",
            "href" => "media",
            "icon" => "fa fa-images",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Ban IP",
            "href" => "bannedips",
            "icon" => "fa fa-ban",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Logy",
            "href" => "logs",
            "icon" => "fa fa-pencil",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Discord",
            "href" => "discord",
            "icon" => "fa fa-discord",
        ]);
        
        $factory->createSeed($this->table, [
            "name" => "Utility",
            "href" => "utils",
            "icon" => "fa fa-box",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Plánovač",
            "href" => "scheduler",
            "icon" => "fa fa-calendar",
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

