<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolioCategoriesSeed 
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
    private $table = "portfolio-categories";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        //insert into portfoliocategories ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Aplikace",
            "url" => "applications",
            "portfolio_type" => "webapp",
            "description" => "Webové aplikace"
        ]);

        $factory->createSeed($this->table, [
            "title" => "Soukromé weby",
            "url" => "soukrome-weby",
            "portfolio_type" => "webapp",
            "description" => "Weby vytvořené pro soukromé účely"
        ]);

        $factory->createSeed($this->table, [
            "title" => "Nezařazené",
            "url" => "nezarazene",
            "portfolio_type" => "nezarazene",
            "description" => "Nezařazené weby"
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

