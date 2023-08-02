<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_gallery_collectionsSeed 
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
    private $table = "zos_gallery_collections";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into zos_gallery_collections ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [    
            "title" => "Pejsci",
            "url" => "pejsci",
            "description" => "Naši pejsci",
        ]);

        $factory->createSeed($this->table, [    
            "title" => "Výstava nové webové stránky",
            "url" => "vystava-nove-stranky",
            "description" => "Aneb, jak jsme si nechali vytvořit web",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

