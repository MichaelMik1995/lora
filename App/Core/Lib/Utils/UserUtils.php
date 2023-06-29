<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;
use App\Core\Database\DB;

class UserUtils
{

    private static $_instance = null;
    private static $_instance_id;
    private static DB $database;

    private function __construct(){}

    public static function instance(DB $database)
    {
        self::$database = $database;

        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }
        
        return self::$_instance;
        
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