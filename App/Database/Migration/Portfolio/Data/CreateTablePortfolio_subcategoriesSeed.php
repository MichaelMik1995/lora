<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolio_subcategoriesSeed 
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
    private $table = "portfolio-subcategories";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into portfolio_subcategories ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "LORA Moduly",
            "url" => "lora-moduly",
            "category_url" => "applications",
            "description" => "Modul vytvořený v PHP frameworku LORA, který je pouze kompatibilní v tomto frameworku",
        ]);

        $factory->createSeed($this->table, [
            "title" => "Webové projekty",
            "url" => "webove-projekty",
            "category_url" => "applications",
            "description" => "Ucelené webové projekty",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

