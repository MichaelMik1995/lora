<?php
namespace Loran\Database;

use App\Database\DatabaseFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableForum_styles 
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
    private $table = "forum-styles";


    public function createOrUpdateTable($factory)
    {
        $create_table = $factory->createTable($this->table);    //Creates new table if this table not already exists
        $column_id = $factory->createTablePrimaryKey();         //Creates primary key column (Defaul: "id")

        //insert your own columns
        $theme_title = $factory->createTableColumn("title", "varchar", 128);
        $theme_url = $factory->createTableColumn("url", "varchar", 128, 0, special: "UNIQUE");
        $main_color = $factory->createTableColumn("main_color", "varchar", 64, 1, default: "#1D242A"); //Main forum color 
        $second_color = $factory->createTableColumn("second_color", "varchar", 64, 1, default: "orange"); //Main forum color
        $text_main_color = $factory->createTableColumn("text_main_color", "varchar", 64, 1, default: "whitesmoke"); //Main forum text color 
        $text_second_color = $factory->createTableColumn("text_second_color", "varchar", 64, 1, default: "#bfbfbf"); //Second forum text color 

        //Save a complete folded table:
        $factory->tableSave([
            $create_table, 
            $column_id,
            
            //Own columns
            $theme_title,
            $theme_url,
            $main_color,
            $second_color,
            $text_main_color,
            $text_second_color,
        ]);

        //Adding post features (foreign keys etc)
        $factory->addIndex("url");
    }
    
    public function removeTable($factory)
    {
        return $factory->removeTable($this->table);
    }
}

