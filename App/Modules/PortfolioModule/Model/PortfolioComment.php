<?php
/**
 * Description of Module Model - PortfolioComment:
 *
 * This model was created for module: Portfolio
 * @author MiroJi
 * Created_at: 1674121049
 */
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

/**
*   Using main module Model
*/
use App\Modules\PortfolioModule\Model\Portfolio;

class PortfolioComment extends Portfolio
{

    protected $model_table = "portfolio-comments";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllPortfolioComment(string $url, string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "portfolio_url=? ORDER BY $order_by", [$url]);
        if(!empty($db_query))
        {
            $returnArray = [];
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $comment_url = $row["url"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["answers"] = $this->database->select($this->table_answers, "comment_url=?", [$comment_url]);
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
    public function getPortfolioComment(string $url): Array
    {
        $db_query = $this->database->selectRow($this->model_table, "url=?", [$url]);
        if(!empty($db_query))
        {
            $content = $db_query["content"];
            
            $db_query["_content"] = $this->easy_text->translateText($content);
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insertPortfolioComment(array $insert_values)
    {
        // Insert new row
        return $this->database->insert($this->model_table, $insert_values);
    }

    public function insertPortfolioCommentAnswer(array $insert_values)
    {
        // Insert new row
        return $this->database->insert($this->table_answers, $insert_values);
    }
    
    public function updatePortfolioComment(array $set, string $url)
    {
        // update row
        return $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deletePortfolioComment(string $url)
    {
        // delete row
        return $this->database->delete($this->model_table, "url=?", [$url]);
    }


} 

