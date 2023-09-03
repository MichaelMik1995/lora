<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolioTypesSeed 
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
    private $table = "portfolio-types";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        //insert into portfoliotypes ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Webová stránka",
            "url" => "webapp",
            "description" => "Všechny portfolio v kategorii webová stránka",
        ]);

        $factory->createSeed($this->table, [
            "title" => "3D Model",
            "url" => "model3d",
            "description" => "3D model",
        ]);

        $factory->createSeed($this->table, [
            "title" => "Textury",
            "url" => "textury",
            "description" => "Textury použitelné pro vývoj her, filmů atd.",
        ]);

        //Not delete!
        $factory->createSeed($this->table, [
            "title" => "Nezařazené",
            "url" => "nezarazene",
            "description" => "Nezařazené itemy",
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

