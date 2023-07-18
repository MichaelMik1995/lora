<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAnnouncementsSeed 
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
    private $table = "announcements";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into announcements ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "První oznámení - Vítejte!",
            "url" => "prvni-oznameni",
            "author" => "111111111",
            "content" => "Vítejte na webovém portálu LORA!"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

