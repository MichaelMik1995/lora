<?php
namespace Loran\Seed;

use App\Database\DatabaseFactory;
use App\Core\Lib\Utils\StringUtils;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableTest_dataSeed 
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
    private $table = "test_data";
    
    public function createSeeds(DatabaseFactory $factory)
    {           
        $string_utils = StringUtils::instance();
        //insert into test_data ($keys) VALUES ($values) -> create ROW

        $random_int = rand(12,32);
       
        $bools = ["true", "false"];

        for($i = 0; $i < $random_int; $i++)
        {
            $random_bool_int = rand(0,1);
            $string_gen = $string_utils->genarateHashedString(12, salt: time().rand(11111, 99999));

            $factory->createSeed($this->table, [
                "parameter_string" => $string_gen,
                "parameter_int" => rand(1111111,9999999),
                "parameter_bool" => $bools[$random_bool_int],
            ]);
        }

        
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

