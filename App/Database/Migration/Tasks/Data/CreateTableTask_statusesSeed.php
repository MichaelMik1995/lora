<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTask_statusesSeed 
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
    private $table = "task_statuses";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into task_statuses ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "name" => "Nový úkol",
            "url" => "novy-ukol",
            "color" => "#0079ca",
            "description" => "Úkol, který je nově zadán",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Zprácovává se",
            "url" => "zpracovava-se",
            "color" => "#a074c4",
            "description" => "Právě zpracovávaný úkol",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Dokončeno",
            "url" => "dokonceno",
            "color" => "#48a487",
            "description" => "Dokončený úkol",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Zrušeno",
            "url" => "zruseno",
            "color" => "#d54000",
            "description" => "Zrušený úkol",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

