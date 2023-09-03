<?php
declare(strict_types=1);

namespace App\Core\Database;
use App\Core\Lib\Utils\DebugUtils;
use App\Exception\LoraException;

use PDO;

/**
 * class mysql
 * connecting to database
 */
class Database
{
    /**
     * 
     * @var int Represents max allowed row limit
     */
    protected $row_limit = 256;
    /**
     *
     * @var \PDO
     */
    protected $connect;
    
    protected $temp_connect = false;

    /**
     *
     * @var array $settings 
     */
    private $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    public string $db_driver;
    
    
    public $table;
    public $route_key = "url";
    public $action;
    public $route_param;


    /**
     * instance of DatabaseEnchanced
     * @var self $instance
     */
    private static $instance;

    /**
     * If called instance has empty parameters -> call default 
     */
    private static array $connection_data = [];

    public function __construct($db_driver, $db_host, $db_name, $db_user, $db_password, $is_factory)
    {
        $this->initialize($db_driver, $db_host, $db_name, $db_user, $db_password, $is_factory);
        
        if($is_factory == false)
        {
           $this->setTableData(); 
        }
        
    }

    /**
     * 
     * @param string $db_driver         <p>Choose database driver: sqlite|mysql|none, default: env("db_driver"); if database factory -> set driver</p>
     * @param string $db_host           <p>Database host (eg: localhost)</p>
     * @param string $db_name           <p>Database name (eg: test)</p>
     * @param string $db_user           <p>Database user (eg: root)</p>
     * @param string $db_password       <p>Database password (eg: mypassword)</p>
     * @param bool $is_factory          <p>Choose TRUE if database factory calls this instance</p>
     * @return self                     <p>Return self class</p>
     */
    public static function instance($db_driver = null, $db_host = null, $db_name = null, $db_user = null, $db_password = null, bool $is_factory = false)
    {
        if (self::$instance === null) 
        {
            self::$instance = new self($db_driver, $db_host, $db_name, $db_user, $db_password, $is_factory);
        }
        
        return self::$instance;
    }
    
    /**
     * Initialize database connection (leave blank if uses ENV variables)
     * @param string $db_host       <p>Database host (eg: localhost)</p>
     * @param string $db_name       <p>Database name (eg: test)</p>
     * @param string $db_user       <p>Database user (eg: root)</p>
     * @param string $db_password   <p>Database password (eg: mypassword)</p>
     */
    public function initialize($db_driver, $db_host, $db_name, $db_user, $db_password, $is_factory)
    {
        //Get Database Driver mysql|sqlite

        if ($db_driver === null && $db_host === null && $db_name === null && $db_user === null && $db_password === null) 
        {
            $db_driver = env("db_driver", false);

            //Set connection variables
            self::$connection_data = match($db_driver){
                "none" => ["driver" => null],
                "mysql" =>  [ 
                                "driver" => $db_driver,
                                "host" => env("db_host", false), 
                                "db_name" => env("db_name", false), 
                                "user" => env("db_user", false), 
                                "password" => env("db_password", false)
                            ],
                "sqlite" => ["driver" => $db_driver, "db_name" => env("db_name", false)],
                default => ["driver" => null]
            };
        }
        else 
        {

            //Set connection variables
            self::$connection_data = match($db_driver){
                "none" => ["driver" => null],
                "mysql" =>  [ 
                                "driver" => $db_driver,
                                "host" => $db_host, 
                                "db_name" => $db_name, 
                                "user" => $db_user, 
                                "password" => $db_password,
                            ],
                "sqlite" => ["driver" => $db_driver, "db_name" => $db_name],
                default => ["driver" => null]
            };
        }
        
        $this->db_driver = $db_driver;

        if(!isset($is_factory))
        {
            $is_factory = false;
        }
        
        //Select connection method
        match($db_driver)
        {
            "none" => null,
            "mysql" => $this->mysqlConnect(),
            "sqlite" => $this->sqliteConnect(self::$connection_data["db_name"], $is_factory),
        };
    }
    
    
    /**
     * 
     * @param string $query
     * @return PDO::query
     */
    public function query($query, $params = []): Array
    {
        $return = $this->connect->prepare($query);
        $return->execute($params);

        return $return->fetchAll(PDO::FETCH_ASSOC);
        
        //return $return->fetch();
    }
    
    ####################################################################################################################
                                                # C.R.U.D. BY ROUTE #
    ####################################################################################################################
    
    public function tableAllData(string $order_by = "id DESC", $limit = "0, 20")
    {
        return $this->select($this->table, "id!=? ORDER BY $order_by", [0], $limit);
    }
    
    /**
     * 
     * @var array $values
     * @return PDO::query
     */
    public function tableInsertByRoute(array $values)
    {   
        return $this->insert($this->table, $values);
    }
    
    public function tableInsert(string $table, array $values)
    {
        if(!empty($values))
        {
            $columns = "";
            $prepared = "";
            $vals = [];
            
            foreach($values as $key => $value)
            {
                $columns .= "`".htmlspecialchars($key)."`,";
                $prepared .= "?,";
                $vals[] = $value;
            }
            
            $insert_cols = rtrim($columns, ",");
            $insert_values = rtrim($prepared, ",");
            
            return $this->query("insert into `$table` ($insert_cols) VALUES ($insert_values)", $vals); 
        }
        else
        {
            throw new LoraException("Hodnoty nesmějí být prázdné!");
        }
    }
    
    /**
     * use tableUpdate method only if $route_param exists
     * @var string $table
     * @var array $set
     * @var string $route_key
     */
    public function tableUpdate(string $table, array $set, $route_key = "id")
    {
        if(!empty($set))
        {
            $set_string = "";
            foreach($set as $key => $value)
            {
                $set_string .= "`$key`='$value',";
            }
            
            $set_complete = rtrim($set_string, ",");
            
            return $this->update($table, $set_complete, $route_key."=?", [$this->route_param]);
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 
     * @return PDO::query
     */
    public function tableRowByRoute()
    {
        return $this->selectRow($this->table, $this->route_key."=?", [$this->route_param]);
    }
    
    public function tableRowByRouteKey($route_key, $order_by = "id ASC")
    {
        return $this->selectRow($this->table, $route_key."=? ORDER BY $order_by", [$this->route_param]);
    }
    
    public function tableRowsByRouteKey(string $route_key, string $order_by = "id ASC")
    {
       return $this->select($this->table, $route_key."=? ORDER BY $order_by", [$this->route_param]); 
    }
    
    
    /**
     * 
     * @param array $set
     * @return \PDO|null
     */
    public function tableUpdateByRoute(array $set)
    {
        if(!empty($set))
        {            
            return $this->update($this->table, $set, $this->route_key."=?", [$this->route_param]);
        }
        else
        {
            return null;
        }
    }
    
    public function tableUpdateByRouteKey(array $set, $route_key)
    {
        if(!empty($set))
        {            
            return $this->update($this->table, $set, $route_key."=?", [$this->route_param]);
        }
        else
        {
            return false;
        }
    }
    
    public function tableUpdateById($set = [])
    {
        if(!empty($set))
        {
            return $this->update($this->table, $set, "id=?", [$this->route_param]);
        }
        else
        {
            return false;
        }
    }
    
    
    public function tableDeleteByRoute()
    {
        $db_query = $this->delete($this->table, $this->route_key."=?", [$this->route_param]);
        if($db_query == true)
        {
            return $db_query;
        }
        else
        {
            throw new LoraException("Nastala chyba při mazání dat!");
        }
    }
    
    public function tableDeleteByRouteKey($route_key)
    {
        $db_query = $this->delete($this->table, $route_key."=?", [$this->route_param]);
        if($db_query == true)
        {
            return $db_query;
        }
        else
        {
            throw new LoraException("Nastala chyba při mazání dat!");
        }
    }

    
    /**
     * Select all columns from table with conditions
     * 
     * @param string $table                         <p>Select from $table</p>
     * @param string $where                         <p>Select condition</p>
     * @param array $params                         <p>Params for execute (?)</p>
     * @return PDO::query
     */
    public function select($table, $where, $params = [], $limit = "50") 
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where LIMIT $limit");
        $return->execute($params);

        return $return->fetchAll();
    }
    
    /**
     * Select $selected columns from table with conditions
     * 
     * @param string $table                         <p>Select from $table</p>
     * @param string $selected                      <p>Select only required columns separated by "," char</p>
     * @param string $where                         <p>Select condition</p>
     * @param array $params                         <p>Params for execute (?)</p>
     * @return PDO::query
     */
    public function selected($table, $selected, $where, $params = []) 
    {
        $return = $this->connect->prepare("SELECT $selected FROM $table WHERE $where");
        $return->execute($params);

        return $return->fetchAll();
    }

    /**
     * Select only one row from table witch conditions
     * 
     * @param string $table                         <p>Select from $table</p>
     * @param string $where                         <p>Select condition</p>
     * @param array $params                         <p>Params for execute (?)</p>
     * @return array
     */
    public function selectRow($table, $where, $params = []) 
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where");
        $return->execute($params);
        return $return->fetch();
    }
    
    /**
     * 
     * @param string $table
     * @param int|string $id
     * @param array $params
     * @return PDO::query
     */
    public function selectLast($table, $id, $params = [])
    {
        $return = $this->connect->prepare("SELECT $id FROM `$table` ORDER BY $id DESC");
        $return->execute($params);
        return $return->fetch();
    }
    
    /**
     * Select random rows from the database with the specified limit and WHERE clause
     *
     * @param string $table
     * @param string $where
     * @param int $limit
     * @param array $params
     * @return array|null
     */
    public function selectRandom(string $table, string $where, int $limit, $params = []): Array|Null
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where ORDER BY RAND() LIMIT $limit");
        $return->execute($params);

        if($limit == 1)
        {
            return $return->fetch();
        }
        else {
            return $return->fetchAll();
        }
    }

    /**
     * Select a newest rows from the database with the specified limit and WHERE clause
     *
     * @param string $table
     * @param string $where
     * @param array $params
     * @param integer $limit
     * @return array|null|bool
     */
    public function selectNewestRows(string $table, string $where, $params = [], $limit = 8): Array|Null|Bool
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where ORDER BY `id` DESC LIMIT $limit");
        $return->execute($params);
        if($limit == 1)
        {
            return $return->fetch();
        }
        else {
            return $return->fetchAll();
        }
    }

    /**
     * Select the oldest rows from the database with the specified limit and WHERE clause
     *
     * @param string $table
     * @param string $where
     * @param array $params
     * @param integer $limit
     * @return array|null
     */
    public function selectOldestRows(string $table, string $where, $params = [], $limit = 8): Array|Null
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where ORDER BY `id` ASC LIMIT $limit");
        $return->execute($params);
        if($limit == 1)
        {
            return $return->fetch();
        }
        else {
            return $return->fetchAll();
        }
    }

    /**
     * 
     * @param string $table
     */
    public function returnLastId($table, $id="id")
    {
        //$getCountedRows = $this->connect->query("SELECT COUNT(*) FROM $table");
        //return $getCountedRows->fetch();
        $selectID = $this->connect->query("SELECT $id FROM `$table` ORDER BY $id DESC LIMIT 1");
        return $selectID->fetch();
    }

    
    /**
     * 
     * @param string $table
     * @param array $values         <p>Defines column index with inserted value (ex.: ["content"=>"hello world"])</p>
     * @return PDO::query
     * @throws LoraException
     */
    public function insert($table, $values) 
    {
        if(!empty($values))
        {
            $columns = "";
            $prepared = "";
            $vals = [];
            
            foreach($values as $key => $value)
            {
                $columns .= "`".htmlspecialchars($key)."`,";
                $prepared .= "?,";
                $vals[] = $value;
            }
            
            $insert_cols = rtrim($columns, ",");
            $insert_values = rtrim($prepared, ",");
            
            return $this->query("insert into `$table` ($insert_cols) VALUES ($insert_values)", $vals); 
        }
        else
        {
            throw new LoraException("Hodnoty nesmějí být prázdné!");
        }
    }

    
    /**
     * 
     * @param string $table <p>In which table we updates row</p>
     * @param array $set    <p>Array of edited columns ["column1"=>"value"]</p>
     * @param string $where <p>String where (can use prepared statements)</p>
     * @param array $params <p>Params for statement $where</p>
     * @return PDO::query|bool   </p>Returns query to PDO or BOOL false</p>
     */
    public function update($table, $set, $where, $params  = []) 
    {
        if(!empty($set))
        {
            $set_string = "";
            $execute_params = [];
            
            foreach($set as $key => $value)
            {
                $set_string .= "`$key`=?,";
                $execute_params[] = $value;
            } 
            $set_complete = rtrim($set_string, ",");
            return $this->query("UPDATE `$table` SET $set_complete WHERE $where", array_merge($execute_params, $params));
        }
        else
        {
            return false;
        }
    }

    
    /**
     * Deletes row in table with conditions
     * 
     * @param string $table                         <p>Select from $table</p>
     * @param string $where                         <p>Select condition</p>
     * @param array $params                         <p>Params for execute (?)</p>
     * @return PDO::class
     */
    public function delete($table, $where, $params = []) 
    {
        $return = $this->connect->prepare("DELETE FROM `$table` WHERE $where");
        $return->execute($params);
        return $return;
    }

    public function deleteTable(string $table)
    {
        $table = strtolower($table);
        $table = str_replace("_", "-", $table);
        
        if(self::$connection_data["driver"] == "sqlite")
        {
            $this->connect->query("DROP TABLE if exists `$table`");
        }
        else
        {
           $this->connect->query("SET FOREIGN_KEY_CHECKS = 0");
           $this->connect->query("DROP TABLE if exists `$table`");
           $this->connect->query("SET FOREIGN_KEY_CHECKS = 1"); 
        }
        
    }

    public function truncateTable(string $table)
    {
        if(self::$connection_data["driver"] == "sqlite")
        {
            $this->connect->query("PRAGMA foreign_keys=OFF");
            $this->connect->query("DELETE FROM \"$table\"");
            $this->connect->query("PRAGMA foreign_keys=ON");
        }
        else
        {
            $this->connect->query("SET FOREIGN_KEY_CHECKS = 0");
            $this->connect->query("TRUNCATE TABLE `$table`");
            $this->connect->query("SET FOREIGN_KEY_CHECKS = 1");
        }
        
        
        
    }
    
    /**
     * Returns number of selected rows with conditions
     * 
     * @param string $table
     * @param string $where
     * @param array $params
     * @return int
     */
    public function countRows($table, $where, $params = [])
    {
        $return = $this->connect->prepare("SELECT * FROM `$table` WHERE $where");
        $return->execute($params);
        return count($return->fetchAll());
    }
    
    
    /**
     * Check if selected value of column exists, if not = return false<br>
     * Specific for checking existing user name
     * 
     * @param string $table
     * @param string $column
     * @param string $unique
     * @return boolean
     */
    public function checkUnique($table, $column, $unique)
    {
        $return = $this->connect->query("SELECT * FROM `$table` WHERE $column='$unique'");
        $count=$return->fetchColumn();
        
        if($count == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 
     * @param bool $array
     * @return array|string
     */
    public static function debug(bool $array = false): Array|String
    {
        $debug_report = [
            "connection_data" => self::$connection_data,
        ];
        
        if($array === true)
        {
            return $debug_report;
        }
        else
        {
            return DebugUtils::generateStringReport($debug_report);
        }
        
    }

    /**
     * @return void
     */
    protected function mysqlConnect()
    {

        $config_data = parse_ini_file("./config/database.ini");

        $db_driver = $config_data["DB_DRIVER"];
        $db_host = $config_data["DB_HOST"];
        $db_name = $config_data["DB_NAME"];
        $db_user = $config_data["DB_USER"];
        $db_password = $config_data["DB_PASSWORD"];

        $dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name;

        try {
            $this->connect = new PDO($dsn, $db_user, $db_password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            try {
                $this->sqliteConnect($db_name);
            } catch (\PDOException $ex) {
                throw new LoraException('Nezdařilo se připojit k Databázi SQLITE: ' . $e->getMessage());
            }
        }
    }

    
    protected function sqliteConnect(string $db_name, bool $is_factory = false)
    {
        try 
        {
            if($is_factory == false)
            {
                $this->connect = new PDO("sqlite:" . env("sqlite_db_path",false)."/".$db_name.".db");
            }
            else 
            {
                $this->connect = new PDO("sqlite:" . "./resources/sql/".$db_name.".db");
            }
            
        } catch (\PDOException $e)
        {
            die("Nepodařilo se připojit k databázi SQLITE: ".$e->getMessage());
        }
    }
    
    /**
     * 
     * @return boolean
     */
    protected function setTableData()
    {
        $route_url = explode("/", @$_SERVER["REQUEST_URI"]);
        
        $this->table = @$route_url[1]; //controller
        $this->action = @$route_url[2]; //action [show|edit|insert|update|delete]
        
        if(@$route_url[2] != "")
        {
            $this->route_param = @$route_url[3];
        }
        
        return true;
    }
}