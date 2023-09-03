<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableBlogSeed 
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
    private $table = "blog";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        //insert into blog ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "První blogový příspěvek",
            "url" => "prvni-blogovy-prispevek",
            "author" => "111111111",
            "content" => "[B]Tučný[/B] Obsah prvního blogového příspěvku",
            "created_at" => time(),
            "updated_at" => time()
        ]);

        //Pro přidání dalších příspěvků opět volejte funkci createSeed()

        /*$factory->createSeed($this->table, [
            "blog_title" => "Další blogový příspěvek",
            "url" => "dalsi-blogovy-prispevek",
            "content" => "Obsah dalšího blogového příspěvku",
            "created_at" => time(),
            "updated_at" => time()
        ]);*/
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

