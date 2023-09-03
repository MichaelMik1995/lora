<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableGame_genresSeed 
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
    
    private $table = "game-genres";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Akční",
            "slug" => "actions",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Adventury",
            "slug" => "adventures",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Skákačky",
            "slug" => "jumping",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Závodní",
            "slug" => "racing",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Střílečky",
            "slug" => "shooters",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Klikačky",
            "slug" => "pointers",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "Ostatní",
            "slug" => "other",
        ]);
        $factory->createSeed($this->table, [        //insert into game_genres ($keys) VALUES ($values) -> create ROW
            "title" => "RPG",
            "slug" => "rpg",
        ]);
    }
    
    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

