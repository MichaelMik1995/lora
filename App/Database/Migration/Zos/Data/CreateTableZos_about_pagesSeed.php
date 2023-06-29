<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_about_pagesSeed 
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
    private $table = "zos_about_pages";
    
    public function createSeeds(MigrationFactory $factory)
    {        
        $factory->createSeed($this->table, [    
            "title" => "PETR PROKEŠ - ZÁCHRANNÁ A ODCHYTOVÁ SLUŽBA PRO ZVÍŘATA",
            "url" => "main",
            "content" => " (doplnit)",
        ]);

        $factory->createSeed($this->table, [    
            "title" => "Vybavení",
            "url" => "vybaveni",
            "content" => "Veškeré vybavení (doplnit)",
        ]);

        $factory->createSeed($this->table, [    
            "title" => "Jak nám můžete pomoci?",
            "url" => "jak-nam-pomoci",
            "content" => "Jak nám můžete pomoci? (doplnit)",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

