<?php
namespace App\Database;

//use App\Core\Database\Database;
use App\Core\Database\Database;
use Lora\Lora\Core\LoraOutput;
use App\Core\Application\DotEnv;

/**
 * Description of DatabaseFactory
 *
 * @author michaelmik
 */
class DatabaseFactory 
{
    use LoraOutput;
    /**
     * 
     * @var string <p>Whole query for creating row</p>
     */
    protected $query = "";
    
    /**
     * 
     * @var string <p>Name of column, which is a primary key</p>
     */
    protected $primary_key;
    
    /**
     * 
     * @var string <p>In which table is creating row</p>
     */
    public $table;

    protected $database;
    
    public function __construct()
    {
        $dot_env = DotEnv::instance();

        $this->database = Database::instance(db_driver: "sqlite", db_name: $_ENV["db_name"], is_factory: true);
    }

    public function __destruct() 
    {
        $this->table = null;
        $this->query = null;
        $this->primary_key = null;
        $check_if_table_exists = null;
    }
    
    /**
     * 
     * @param string $table <p>Start query with creating specific table</p>
     * @return string <p>Returns first string of creating table</p>
     */
    public function createTable(string $table)
    {
        $table = str_replace(["_",",","."], "-", $table);
        $this->table = $table;
        
        return "CREATE TABLE IF NOT EXISTS `".$table."` (";
    }
    
    
    /**
     * 
     * @param string $column_name <p>Define new column name</p>
     * @param string $column_type <p>Define new column type [varchar,int,text ...] DEFAULT: int</p>
     * @param int $max_chars <p>Max chars for column DEFAULT: 11</p>
     * @param int $nullable <p>Is column NULL? [0|1] DEFAULT: 0</p>
     * @param string $default <p>If $nullable=0 -> set default value DEFAULT: ""</p>
     * @param string $special </p>Set special for column [UNIQUE] DEFAULT: ""</p>
     * @return string <p>Returns complete query sentence</p>
     */
    public function createTableColumn(string $column_name, string $column_type="int", int $max_chars = 11, int $nullable = 0, string $default = "", string $special="")
    {
        if($nullable == 0)
        {
            $null = "NOT NULL";
        }
        else if($nullable == 1)
        {
            $null = "NULL";
        }
        else
        {
            echo 'Parameter $nullable must be only 0|1';
            die();
        }
        
        if($default == "")
        {
            $default_value = "";
        }
        else
        {
            $default_value = "DEFAULT '$default'";
        }
        
        if($this->database->db_driver == "sqlite")
        {
            $sqlite_types = [
                "varchar" => "TEXT",
                "int" => "INTEGER",
                "float" => "REAL",
                "bool" => "BLOB",      
            ];
            
            return "\"$column_name\" ".$sqlite_types[$column_type]." $null $special $default_value,";
        }
        else
        {
            return "`$column_name` $column_type($max_chars) $null $special $default_value,";
        }
        
        
    }

    public function timestamp()
    {
        if($this->database->db_driver == "sqlite")
        {
            return "\"created_at\" INTEGER NULL, \"updated_at\" INTEGER NULL, ";
        }
        else 
        {
            return "`created_at` int(20) NULL, `updated_at` int(20) NULL, ";
        }
        
    }
    
    /**
     * 
     * @param string $primary_key_column
     * @return string
     */
    public function createTablePrimaryKey(string $primary_key_column = "id")
    {
        $this->primary_key = $primary_key_column;
        
        if($this->database->db_driver == "sqlite")
            {
                return " `$primary_key_column` INTEGER NOT NULL,";
            }
            else
            {
                return "`$primary_key_column` int(11) NOT NULL auto_increment,";
            }
            
        
    }
    
    
    /**
     * 
     * @param string $table
     * @param array $columns
     * @return void
     */
    public function createSeed(string $table, array $columns)
    {
        $table = str_replace("_","-", $table);

        $check_table_exists = "DESCRIBE `$table`";

        if(!empty($check_table_exists))
        {
            if(!empty($columns))
            {
                $column = "";
                $values = "";

                foreach ($columns as $key=>$value)
                {
                    $column .= "`$key`,";
                    $values .= "'$value',";
                }

                $trimmed_column = rtrim($column, ",");
                $trimmed_values = rtrim($values, ",");

                LoraOutput::output("Migrating test Seeds for |$table| proceed succesfully", "success");
                return $this->database->query("INSERT INTO `$table` ($trimmed_column) VALUES ($trimmed_values)");
            }
            else
            {
                
                return LoraOutput::output("Columns of new row for table | $table | is empty! Nothing to migrate!", "error");
            }
        }
        else 
        {
            return LoraOutput::output("Table | $table | not exists ! Nothing to migrate!", "error");
        }
    }

    public function tableSave(array $columns)
    {
        $table = $this->table;
        
        $check_if_table_exists = "DESCRIBE `$table`";
        
        if($check_if_table_exists)
        {
            $table_content = "";
            foreach($columns as $col)
            {
                $table_content .= $col;
            }

            if($this->database->db_driver == "sqlite")
            {
                $end_query = "PRIMARY KEY(".$this->primary_key." AUTOINCREMENT));";
            }
            else
            {
                $end_query = "PRIMARY KEY  (`".$this->primary_key."`) )";
            }
            

            $this->table = $table;
            $this->query = $table_content.$end_query."\n";
            $check_if_table_exists = null;
            $this->queryTableCreate();
        }
        else
        {
            LoraOutput::output("Table | $table | already exists! Nothing to migrate!", "warning");
        }
    }

    public function foreignKey(string $column, string $from_table, string $from_table_column)
    {
        //FOREIGN KEY("id") REFERENCES "role-id"("user_uid")
        //$this->database->query("ALTER TABLE `".$this->table."` ADD CONSTRAINT `".$column."` FOREIGN KEY (`".$column."`) REFERENCES `".$from_table."` (`".$from_table_column."`) ON DELETE CASCADE ON UPDATE NO ACTION;");
        
        if($this->database->db_driver == "mysql")
        {
            LoraOutput::output(">> ONLY MYSQL: Added Foreign key '$column' in table: `".$this->table."` REFERENCES TO `$from_table` -> '$from_table_column'");
        }
    }

    public function addIndex(string $column)
    {
        if($this->database->db_driver == "sqlite")
        {
            $this->database->query("DROP INDEX IF EXISTS idx_".$column);
            $this->database->query("CREATE UNIQUE INDEX 'idx_".$this->table."_".$column."' ON \"".$this->table."\"($column);");
            LoraOutput::output(">> INDEX $column created for table ".$this->table." with prefix idx_ \n");
        }
        else 
        {
            $this->database->query("ALTER TABLE `".$this->table."` ADD INDEX(`$column`)");
            LoraOutput::output(">> INDEX $column created for table ".$this->table." with");
        }
        
    }

    public function removeTable(string $table)
    {
        LoraOutput::output("Dropping table `$table` from database ... ", "warning");
        $this->database->deleteTable($table);

        $this->table = "";
        $this->query = "";
    }

    /**
     * Truncate table by $table
     * @var string $table
     * @return PDO::class
     */
    public function truncateTable(string $table)
    {
        $table = str_replace(["_"], "-", $table);

        $this->database->truncateTable($table);
    }

    /**
     * Summary of close
     * @return bool
     */
    public function close(): Bool
    {
        $this->table = null;
        $this->query = null;
        $this->primary_key = null;
        $check_if_table_exists = null;
        return true;
    }
    
    private function queryTableCreate()
    {

        if($this->database->db_driver == "sqlite")
        {
            $this->database->query("PRAGMA foreign_keys=OFF");
            $this->database->query($this->query);
            $this->database->query("PRAGMA foreign_keys=ON");
        }
        else
        {
            $this->database->query("SET FOREIGN_KEY_CHECKS=0");
            $this->database->query($this->query);
            $this->database->query("SET FOREIGN_KEY_CHECKS=1");
        }
        


        $message = "Migration of table |".$this->table."| complete! (CreateOrUpdate) \n";
       
        //$this->table = "";
        $this->query = "";

        return LoraOutput::output($message, "success");
    }
   
}
