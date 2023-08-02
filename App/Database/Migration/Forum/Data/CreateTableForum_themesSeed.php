<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_themesSeed 
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
    private $table = "forum-themes";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into forum_themes ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "name" => "Hlavní téma",
            "url" => "hlavni-tema",
            "content" => "Sample of main forum theme",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

