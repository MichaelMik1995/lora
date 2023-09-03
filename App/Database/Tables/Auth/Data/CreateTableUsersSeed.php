<?php
namespace Loran\Seed;

use App\Core\Lib\Utils\StringUtils;
use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableUsersSeed 
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
    private $table = "users";
    
    public function createSeeds(DatabaseFactory $factory)
    {

        $string_utils = StringUtils::instance();
        //User Admin
        $factory->createSeed($this->table, [
            "uid" => "111111111",
            "name" => "Admin",
            "real_name" => "Administrátor",
            "surname" => "Lora",
            "gender" => "man",
            "email" => "admin@localhost.cz",
            "verify_code" => $string_utils->genarateHashedString(11),
            "email_verified_at" => time(),
            "password" => $string_utils->generateHashedPassword("admin"),
            "registration_date" => time(),
            "last_login" => 0,
        ]);

        //User Guest
        $factory->createSeed($this->table, [
            "uid" => "222222222",
            "name" => "Guest",
            "real_name" => "Host",
            "surname" => "Lora",
            "gender" => "man",
            "email" => "guest@localhost.cz",
            "verify_code" => $string_utils->genarateHashedString(11),
            "email_verified_at" => time(),
            "password" => $string_utils->generateHashedPassword("guest"),
            "registration_date" => time(),
            "last_login" => 0,
        ]);
    }

    public function truncateTable(DatabaseFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

