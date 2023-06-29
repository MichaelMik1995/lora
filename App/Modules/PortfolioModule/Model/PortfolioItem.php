<?php
/**
 * Description of Module Model - PortfolioPortfolioItem:
 *
 * This model was created for module: Portfolio
 * @author MiroJi
 * Created_at: 1674120942
 */
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

/**
*   Using main module Model
*/
use App\Modules\PortfolioModule\Model\Portfolio;

class PortfolioItem extends Portfolio
{

    protected $model_table = "portfolio";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllPortfolioPortfolioItem(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
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
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getPortfolioPortfolioItemByCategory(string $category, string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "category_url=? ORDER BY $order_by", [$category]);
        
        if(!empty($db_query))
        {
            $i=0;
            foreach ($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $item_url = $row["url"];

                $get_evals = $this->database->select($this->table_reviews, "portfolio_url_key=?", [$item_url]);

                if(!empty($get_evals))
                {
                    $average_count = 0;

                    foreach ($get_evals as $k)
                    {
                        $get_evaluation = $k["evaluation"];

                        $average_count += $get_evaluation;
                    }

                    $final_average = $average_count / count($get_evals);
                }
                else
                {
                    $final_average = 0;
                }
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["evaluation_average"] = $final_average;
                $db_query[$id]["count_comments"] = $this->database->countRows($this->table_comments, "portfolio_url=?", [$item_url]);
            
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
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getPortfolioPortfolioItemNew(string $order_by = "created_at DESC"): Array
    {
        $db_query = $this->database->select($this->model_table, "id!=? ORDER BY $order_by", [0], 5);
        
        if(!empty($db_query))
        {
            $i=0;
            foreach ($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $item_url = $row["url"];

                $get_evals = $this->database->select($this->table_reviews, "portfolio_url_key=?", [$item_url]);

                if(!empty($get_evals))
                {
                    $average_count = 0;

                    foreach ($get_evals as $k)
                    {
                        $get_evaluation = $k["evaluation"];

                        $average_count += $get_evaluation;
                    }

                    $final_average = $average_count / count($get_evals);
                }
                else
                {
                    $final_average = 0;
                }
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["evaluation_average"] = $final_average;
                $db_query[$id]["count_comments"] = $this->database->countRows($this->table_comments, "portfolio_url=?", [$item_url]);
            
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
    public function getPortfolioPortfolioItem(string $url): Array
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
    
    public function insertPortfolioPortfolioItem(array $insert_values, string $url)
    {

        $item_path = __DIR__."/../public/img/item/$url";
        if(!is_dir($item_path))
        {
            mkdir($item_path);
            mkdir($item_path."/image");
            mkdir($item_path."/image/thumb");
        }

        if(isset($_FILES["images"]) && count($_FILES["images"]) > 0)
        {
            $this->uploader->uploadImages("images", $item_path."/image");
        }

        // Insert new row
        $this->database->insert($this->model_table, $insert_values);
    }
    
    public function updatePortfolioPortfolioItem(array $set, string $url)
    {
        $item_path = __DIR__."/../public/img/item/$url";
        if(!is_dir($item_path))
        {
            mkdir($item_path);
            mkdir($item_path."/image");
            mkdir($item_path."/image/thumb");
        }

        if(isset($_FILES["images"]) && count($_FILES["images"]) > 0)
        {
            $this->uploader->uploadImages("images", $item_path."/image");
        }
        // update row
        $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deletePortfolioPortfolioItem(string $url)
    {
        $item_path = __DIR__."/../public/img/item/$url";
        if(is_dir($item_path."/image/thumb"))
        {

            //Thumbs
            foreach (glob($item_path."/image/thumb/*") as $thumb)
            {
                unlink($thumb);
            }
            rmdir($item_path."/image/thumb");

            //images
            foreach (glob($item_path."/image/*") as $image)
            {
                unlink($image);
            }
            rmdir($item_path."/image");

            //folder
            rmdir($item_path);


        }

        //reviews
        $db_query_comments = $this->database->select($this->table_comments, "portfolio_url=?", [$url]);
        if(!empty($db_query_comments))
        {
            foreach($db_query_comments as $comment)
            {
                $comment_url = $comment["url"];
                $this->database->delete($this->table_answers, "comment_url=?", [$comment_url]);
            }
        }

        $this->database->delete($this->table_comments, "portfolio_url=?", [$url]);
        $this->database->delete($this->table_reviews, "portfolio_url_key=?", [$url]);
        $this->database->delete($this->model_table, "url=?", [$url]);
    }


} 

