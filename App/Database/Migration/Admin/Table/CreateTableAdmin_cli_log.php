<?php
namespace Loran\Migration;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableAdmin_cli_log 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;
    
    /**
    * Table with chars (_) will be replaced to "-" (forum_table -> forum-table)
    * @var string $table
    */
    private $table = "admin-cli-log";


    public function createOrUpdateTable($factory)
    {
            
            $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
            $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")
            //insert your own columns
        $exec = $factory->createTableColumn("cmd_execute", "varchar", 512);
        $output = $factory->createTableColumn("cmd_output", "varchar", 4096, 1);
        $type = $factory->createTableColumn("cmd_type", "varchar", 32, 1);
                                       
            //Usefull for articles -> date of created / updated in timestamp
            $timestamp = $factory->timestamp();            
            
            //Save a complete folded table:
            $factory->tableSave([
                $create_table, 
                $column_id,
                //Own columns
                $exec,
                $output,
                $type,
                $timestamp
                ]);

            //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

