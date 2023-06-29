<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_gallerySeed 
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
    private $table = "zos_gallery";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into zos_gallery ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [    
            "title" => "Arran",
            "url" => "arran",
            "collection" => "pejsci",
            "description" => "Fotky jednoho úžasného pejska",
            "evaluation" => "3",
            "created_at" => time(),
            "updated_at" => time(),
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

