<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTablePortfolioSeed 
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
    private $table = "portfolio";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        //insert into portfolio ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "DXGamePRO",
            "url" => "dxgamepro-web",
            "category_url" => "soukrome-weby",
            "author" => "111111111",
            "short_description" => "Herní portál DXGamePRO",
            "content" => "{doplnit}",
            "web_url" => "https://www.dxgamepro.cz",

        ]);

        $factory->createSeed($this->table, [
            "title" => "GOTA Customs",
            "url" => "gota-customs-web",
            "category_url" => "soukrome-weby",
            "author" => "111111111",
            "short_description" => "Jednoduchý eshop systém napsaný v PHP",
            "content" => "{doplnit}",
            "web_url" => "https://www.gotacustoms.eu",
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

