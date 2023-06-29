<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableDocumentationSeed 
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
    private $table = "documentation";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        //insert into documentation ($keys) VALUES ($values) -> create ROW
        $factory->createSeed($this->table, [
            "title" => "Vítejte ve frameworku",
            "url" => "vitejte-ve-framworku",
            "version" => "3-2",
            "category" => "vitejte",
            "content" => "[H1]Vítejte ve frameworku LORA[/H1]",
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

