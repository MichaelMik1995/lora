<?php
/**
 * Description of Module Model - PortfolioReview:
 *
 * This model was created for module: Portfolio
 * @author MiroJi
 * Created_at: 1674121057
 */
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

/**
*   Using main module Model
*/
use App\Modules\PortfolioModule\Model\Portfolio;

class PortfolioReview extends Portfolio
{

    protected $model_table = "portfolio-reviews";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllPortfolioReview(string $item_url, string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "portfolio_url_key=? ORDER BY $order_by", [$item_url]);
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
    public function getPortfolioReview(string $url): Array
    {
        $db_query = $this->database->selectRow($this->model_table, "portfolio_url_key=?", [$url]);
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
    
    public function insertPortfolioReview(array $insert_values)
    {
        // Insert new row
        return $this->database->insert($this->model_table, $insert_values);
    }
    
    public function updatePortfolioReview(array $set, string $url)
    {
        // update row
        return $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deletePortfolioReview(string $url)
    {
        // delete row
        return $this->database->delete($this->model_table, "url=?", [$url]);
    }


} 

