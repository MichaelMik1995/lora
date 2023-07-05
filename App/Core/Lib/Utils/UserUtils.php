<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;

use App\Core\Database\Database;
use App\Core\DI\DIContainer;

class UserUtils
{

    private static $_instance = null;
    private static $_instance_id;
    private static Database $database;

    public function __construct(DIContainer $container)
    {
        self::$database = $container->get(Database::class);
    }

    public static function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    /**
     * @param int $user_uid
     */
    public function getUserName(int $user_uid)
    {
        $data = self::$database->selectRow("users", "uid=?", [$user_uid]);
        return $data["name"];
    }

        /**
     * 
     * @param int $uid <p>Set UID of required user</p>
     * @return string <p>Returns user's name or Unknown</p>
     */
    public function getAuthor($uid = -1)
    {
        $db_query = $this->database->selectRow($this->user_table, "uid=?", [$uid]);
        
        if(!empty($db_query))
        {
            return $db_query["name"];
        }
        else
        {
            return "Unknown";
        }
    }
}