<?php
/**
 * Description of Module Model - Games:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\GamesModule\Model;

use App\Core\Model;

class Games extends Model
{
    protected $table = "games";

    public $route_param;
    
    public function __construct(string $route_param = null) {
        $this->init();

        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }
        else
        {
            $this->database->route_param = $this->route_param;
        }
        
        //$this->database->route_key = "url";       //Uncheck if route key is different from "url"
        //$this->database->table = $this->table;    //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: "id ASC")</p>
     * @return Array <p>Returns all records from table</p>
     */
    public function getAll(string $order_by = "id ASC"): Array {
        $db_query = $this->database->tableAllData($order_by);
        if (!empty($db_query)) {
            $returnArray = [];
            $i = 0;
            foreach ($db_query as $row) {
                $id = $i++;
                
            }

            return $db_query;
        } else {
            return [];
        }
    }

    public function getByGenre(string $genre_slug, string $order_by = "evaluation DESC"): Array 
    {
        $db_query = $this->database->select($this->table, "genre_slug=? ORDER BY $order_by", [$genre_slug]);
        if (!empty($db_query)) {
            $returnArray = [];
            $i = 0;
            foreach ($db_query as $row) {
                $id = $i++;
                $description = $row["description"];

                $db_query[$id]["_description"] = $this->easy_text->translateText($description, "60%");
                
            }

            return $db_query;
        } else {
            return [];
        }
    }

    public function search()
    {

    }
    
    public function getTags(): Array
    {
        $select_games = $this->database->select($this->table, "id!=?", [0]);
        if(!empty($select_games)){
            $tags = [];

            foreach ($select_games as $game)
            {
                $game_tags = $game["tags"];
                $explode = explode(",", $game_tags);

                $tags = array_merge($tags, $explode);
            }

            return array_unique($tags);
        }
        else
        {
            return [];
        }
    
    }

    /**
     * @return Array <p>Return one row from table and store it in array, where $result["column"] = "column_value"</p>
     */
    public function get(): Array {
        $db_query = $this->database->selectRow($this->table, "url=?", [$this->route_param]);
        if (!empty($db_query)) {
            $content = $db_query["description"];
            $get_tags = $db_query["tags"];
            $tags = [];

            if(!empty($get_tags))
            {
                $tags = explode(",", $get_tags);

            }

            $db_query["array_tags"] = array_unique($tags);

            $db_query["_description"] = $this->easy_text->translateText($content);

            return $db_query;
        } else {
            return [];
        }
    }

    /**
     * @param array $values <p>Array values for insert ["col"=>"value", ...]</p>
     * @return \PDO
     */
    public function insert(array $values) {
        return $this->database->tableInsertByRoute($values);
    }

    /**
     * @param array $values <p>Array values for update ["col"=>"value", ...]</p>
     * @return \PDO
     */
    public function update(array $values) {
        return $this->database->tableUpdateByRoute($values);
    }

    /**
     * @return \PDO
     */
    public function delete() {
        return $this->database->tableDeleteByRoute();
    }
}
?>
