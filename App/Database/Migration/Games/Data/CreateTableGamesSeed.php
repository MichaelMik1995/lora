<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableGamesSeed 
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
    private $table = "games";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //Test data
        $factory->createSeed($this->table, [        //insert into games ($keys) VALUES ($values) -> create ROW
            "name" => "Story of Vhallay",
            "url" => "story-of-vhallay",
            "genre_slug" => "rpg",
            "tags" => "roleplay,rpg,story",
            "description" => "Game description",
            "evaluation" => "5",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Grand theft auto: San Andreas",
            "url" => "gta-sa",
            "genre_slug" => "actions",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of GTA",
            "evaluation" => "4.5",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Grand theft auto: Vice City",
            "url" => "gta-vc",
            "genre_slug" => "actions",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of GTA",
            "evaluation" => "4.34",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Grand theft auto: Liberty City",
            "url" => "gta-lc",
            "genre_slug" => "actions",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of GTA",
            "evaluation" => "2.6",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Grand theft auto: IV",
            "url" => "gta-iv",
            "genre_slug" => "actions",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of GTA",
            "evaluation" => "3.2",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Need for speed: 1",
            "url" => "nfs-1",
            "genre_slug" => "racing",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of NFS",
            "evaluation" => "5",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Need for speed: 2",
            "url" => "nfs-2",
            "genre_slug" => "racing",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of NFS 2",
            "evaluation" => "5",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Need for speed: 3",
            "url" => "nfs-3",
            "genre_slug" => "racing",
            "tags" => "freestyle,cars,guns,thirdperson",
            "description" => "Game description of NFS 2",
            "evaluation" => "4.6",
            "created_at" => time(),
            "updated_at" => time(),
        ]);


    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

