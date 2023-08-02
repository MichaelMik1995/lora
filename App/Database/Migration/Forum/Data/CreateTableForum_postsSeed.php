<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_postsSeed 
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
    private $table = "forum-posts";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into forum_posts ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Testovací příspěvek",
            "author" => "111111111",
            "url" => "První testovaí příspěvek",
            "category_url" => "podtema-hlavniho",
            "content" => "Zde zadejte svůj problém",
            "solved" => "0"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

