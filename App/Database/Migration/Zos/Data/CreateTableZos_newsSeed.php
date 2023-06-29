<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_newsSeed 
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
    private $table = "zos_news";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "title" => "První příspěvek",
            "url" => "prvni-prispevek",
            "author" => "111111111",
            "content" => "[H3]Uživatel [B]Admin[/B] zde napsal první příspěvek![/H3]",
            "validated" => "1",
            "created_at" => time(),
            "updated_at" => time(),

        ]);

        $factory->createSeed($this->table, [
            "title" => "Druhý příspěvek prezentující obrázek",
            "url" => "druhy-prispevek",
            "author" => "111111111",
            "content" => "[H5]Uživatel [B]Admin[/B] zde napsal druhý příspěvek![/H5]",
            "validated" => "1",
            "created_at" => time(),
            "updated_at" => time(),

        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

