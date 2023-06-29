<?php
/*
    Plugin DBaser generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\DBaser;

use App\Core\Database\Database;

class DBaser
{
    const
        GET = 0,
        CREATE = 1,
        INSERT = 2,
        UPDATE = 3,
        DELETE = 4;
    /**
     * 
     * @var string <p>Query constructor</p>
     */
    private string $query_string = "";

    private string $query_start = "";
    private string $c_table_columns = "";



    protected $database;
    
    /**
     * 
     * @var string
     */
    private string $table = "";

    private int $table_operation = 0;

    private string $id = "";
    
    /**
     * 
     * @var array <p>Arrays for execution query in \PDO</p>
     */
    private array $execute_params = [];
    
    private array $restricted_chars = [];

    private bool $second_condition = false;
    
    
    public function __construct(Database $database)
    {
        $this->restricted_chars = [
            ".",",","'","\\","//","/","\""
        ];

        $this->database = $database;
    }

    #########################   TABLE   ########################################
    ############################################################################
    
    /**
     * Class inicializator -> create instance and apply table
     * 
     * @var string $table
     * @return DBaser
     */
    public function table(string $table): Dbaser
    {

        $this->table = str_replace([",","."], "-", $table);
        return $this;

    }

    public function operation(string $operation = "get", string $select_columns = "*")
    {
        $operation = strtolower($operation);

        $table_operation = match($operation)
        {
            "get" => $this->table_operation = $this::GET,
            "create" => $this->table_operation = $this::CREATE,
            "insert" => $this->table_operation = $this::INSERT,
            "update" => $this->table_operation = $this::UPDATE,
            "delete" => $this->table_operation = $this::DELETE,

            "--g" => $this->table_operation = $this::GET,
            "--c" => $this->table_operation = $this::CREATE,
            "--i" => $this->table_operation = $this::INSERT,
            "--u" => $this->table_operation = $this::UPDATE,
            "--d" => $this->table_operation = $this::DELETE
        };


        //$this->query_string .= "SELECT $columns FROM ".$this->table." ";
        //return $this;

        $query_start = match($this->table_operation)
        {
            $this::GET => $this->query_start = "SELECT $select_columns FROM `".$this->table."` ",
            $this::CREATE => $this->query_start = "CREATE TABLE `".$this->table."` IF NOT EXISTS ",
            $this::INSERT => $this->query_start = "",
            $this::UPDATE => $this->query_start = "",
            $this::DELETE => $this->query_start = "",

        };

        $this->table_operation = $table_operation;
        return $this;
    }

    
    /**
     * 
     * @param string $table_name
     * @param bool $drop_old
     */
    public function create()
    {
        
        $this->query_string .= "CREATE TABLE IF NOT EXISTS `".$this->table."` (";
        return $this;
    }

    public function createId(string $id_name = "id")
    {
        $this->query_string .= "`$id_name` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
        $this->id = $id_name;
        return $this;
    }

    public function createColumn(
        string $column_name, 
        string $column_type, 
        int $max_chars = 11, 
        bool $is_null = false,
        bool $is_unique = false,
        string $default_value = null
        )
    {
        $null = ($is_null == true) ? 'NULL' : 'NOT NULL';
        
        $default = ($default_value == null) ? null : "DEFAULT '$default_value' ";
        
        $this->c_table_columns .=  " `$column_name` $column_type($max_chars) $null $default,";
        return $this;
    }

    public function stringColumn(
        string $column_name, 
        int $max_chars = 512,
        bool $is_null = false, 
        string $charset="utf8_czech_ci", 
        string $default_value=null
    )
    {
        $null = ($is_null == true) ? 'NULL' : 'NOT NULL';
        $default = ($default_value == null) ? "" : "DEFAULT '$default_value'";

        $this->c_table_columns .=  " `$column_name` varchar($max_chars) COLLATE $charset $null $default, ";
        return $this;
    }

    public function timestamps()
    {

        $this->query_string .= " `created_at` int(11) NOT NULL, `updated_at` int(11) NOT NULL,";
        return $this;
    }


    public function addFKey(string $column, string $from_table, string $from_table_column)
    {
        $this->query_string .= "ALTER TABLE `".$this->table."` ADD CONSTRAINT `".$column."` FOREIGN KEY (`".$column."`) REFERENCES `".$from_table."` (`".$from_table_column."`) ON DELETE CASCADE ON UPDATE NO ACTION;";
    }

    public function view(): String
    {
        $this->queryConstruct();
        var_dump($this->execute_params)."<br>";
        return $this->query_string;
    }

    private function queryConstruct()
    {
        $table_create = $this->query_string;
        $columns = rtrim($this->c_table_columns, ",");

        if($this->table_operation == $this::CREATE)
        {
            $final_query = $this->query_start.$columns.") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci";
        }
        else
        {
            $final_query = $this->query_start.$this->query_string;
        }
        
        echo $final_query."BBB";

        $this->query_string = $final_query;
        return $final_query;
    }
    
    /**
     * 
     * @param string $table_name
     * @param bool $with_data
     */
    public function moveTable(string $table_name, bool $with_data)
    {
        return $this;
    }
    
    /**
     * 
     * @param string $table_name
     * @param bool $with_data
     */
    public function copyTable(string $table_name, bool $with_data)
    {
        return $this;
    }
    
    /**
     * 
     * @param string $new_table_name
     * @param string $old_table_name
     */
    public function renameTable(string $new_table_name, string $old_table_name)
    {
        return $this;
    }
        
    /**
     * 
     * @param string $table_name
     */
    public function deleteTable(string $table_name)
    {
        return $this;
    }
    

    public function where(string $condition, array $params = [])
    {
        if($this->second_condition == true)
        {
            $this->query_string .= "( $condition ) ";
        }
        else
        {
            $this->query_string .= " WHERE  $condition  ";
        }
        
        $this->execute_params = array_merge($this->execute_params, $params);
        return $this;
    }

    public function and()
    {
        $this->second_condition = true;
        $this->query_string .= " AND ";
        return $this;
    }

    public function or()
    {
        $this->second_condition = true;
        $this->query_string .= " OR ";
        return $this;
    }

    public function join()
    {

    }

    public function order(string $order_by = "id ASC")
    {
        $this->query_string .= "ORDER BY $order_by";
        return $this;
    }
    
    #########################   EXEC   #########################################
    ############################################################################
    
    public function save()
    {
        $query = $this->queryConstruct();
        var_dump($this->execute_params)."<br>";
        var_dump($query)."<br>";
        return $this->database->query($query, $this->execute_params);
        
    }
    
    public function isValid(): Bool
    {
        return true;
    }
    
    public function isError(): Bool
    {
        return false;
    }
    
    
    private function wrapError()
    {
        
    }
    
    /**
     * 
     */
    private function constructQuery()
    {
        
    }
}
