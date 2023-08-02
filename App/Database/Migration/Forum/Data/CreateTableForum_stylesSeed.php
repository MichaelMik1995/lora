<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_stylesSeed 
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
    private $table = "forum-styles";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into forum_styles ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Výchozí modrá",
            "url" => "default-blue"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

