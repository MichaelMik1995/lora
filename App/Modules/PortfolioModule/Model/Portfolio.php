<?php
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

use App\Core\Model;

class Portfolio extends Model
{

    protected $table = "portfolio";
    protected $table_categories = "portfolio-categories";
    protected $table_types = "portfolio-types";
    protected $table_reviews = "portfolio-reviews";
    protected $table_comments = "portfolio-comments";
    protected $table_answers = "portfolio-comment-answers";

    
    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        //$this->database->table = $this->table; //Uncheck if table name is not like controller name
    }
    
    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table portfolio</p>
     */
    public function getAll(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->tableAllData($order_by);
        if(!empty($db_query))
        {
            $returnArray = [];
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
            }
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function get(string $route_key="url"): Array
    {
        $db_query = $this->database->tableRowByRoute();
        if(!empty($db_query))
        {
            $content = $db_query["content"];
            $item_url = $db_query["url"];
            $get_evals = $this->database->query("SELECT AVG('evaluation') FROM ".$this->table_reviews." WHERE portfolio_url_key=?", [$item_url]);
            
            $db_query["_content"] = $this->easy_text->translateText($content);
            $db_query["evaluation_average"] = $get_evals;
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insert(array $insert_values)
    {
        // Insert new row
        return $this->database->tableInsert($this->table, $insert_values);
    }
    
    public function update(array $set, string $route_key = "url")
    {
        // update row
        return $this->database->tableUpdateByRoute($set, $route_key);
    }
    
    public function delete(string $route_key = "url")
    {
        // delete row
        return $this->database->tableDeleteByRoute($route_key);
    }
}
?>

