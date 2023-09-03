<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_categoriesSeed 
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
    private $table = "forum-categories";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        //insert into forum_categories ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "name" => "Podtéma hlavního téma",
            "url" => "podtema-hlavniho",
            "theme_url" => "hlavni-tema",
            "content" => "Sample of subtheme"
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

