<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_post_commentsSeed 
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
    private $table = "forum-post-comments";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into forum_post_comments ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "col" => "value",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

