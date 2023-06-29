<?php
namespace Loran\Migration;

/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_services 
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
    private $table = "zos-services";


    public function createOrUpdateTable($factory)
    {

        $create_table = $factory->createTable($this->table); //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey(); //Creates primary key column (Defaul: "id")
        //insert your own columns
        $name = $factory->createTableColumn("name", "varchar", 128);
        $url = $factory->createTableColumn("url", "varchar", 256, special: "UNIQUE");
        $type = $factory->createTableColumn("type", "int", 1, 0, "0");
        $short_desc = $factory->createTableColumn("short_description", "varchar", 1024);
        $content = $factory->createTableColumn("content", "varchar", 4096);

        //Usefull for articles -> date of created / updated in timestamp
        $timestamp = $factory->timestamp();

        //Save a complete folded table:
        $factory->tableSave([
            $create_table,
            $column_id,
            //Own columns
            $name,
            $url,
            $type,
            $short_desc,
            $content,
            $timestamp
        ]);

        //Adding post features (foreign keys etc)
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

