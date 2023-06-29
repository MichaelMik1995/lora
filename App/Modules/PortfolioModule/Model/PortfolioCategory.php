<?php
/**
 * Description of Module Model - PortfolioCategory:
 *
 * This model was created for module: Portfolio
 * @author MiroJi
 * Created_at: 1675171984
 */
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

/**
*   Using main module Model
*/
use App\Modules\PortfolioModule\Model\Portfolio;

class PortfolioCategory extends Portfolio
{

    protected $model_table = "portfolio-categories";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllPortfolioCategory(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
        if(!empty($db_query))
        {
            $returnArray = [];
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["description"];
                
                $db_query[$id]["_description"] = $this->easy_text->translateText($content);
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
    public function getPortfolioCategoriesByUrl(string $type, string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "portfolio_type=? ORDER BY $order_by", [$type]);
        if(!empty($db_query))
        {
            $returnArray = [];
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["description"];
                
                $db_query[$id]["_description"] = $this->easy_text->translateText($content);
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
    public function getPortfolioCategory(string $url): Array
    {
        $db_query = $this->database->selectRow($this->model_table, "url=?", [$url]);
        if(!empty($db_query))
        {
            $content = $db_query["description"];
            
            $db_query["_description"] = $this->easy_text->translateText($content);
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insertPortfolioCategory(array $insert_values, string $url)
    {
        // Insert new row
        $this->database->insert($this->model_table, $insert_values);

        $path = __DIR__."/../public/img/category/$url";
        if(!is_dir($path))
        {
            mkdir($path);
            mkdir($path."/image");
            mkdir($path."/image/thumb");
        }

        if(($_FILES["image"]["size"] > 0))
        {
            $this->uploader->uploadImage("image", __DIR__."/../public/img/category/$url/image", "main", "png");
        }
    }
    
    public function updatePortfolioCategory(array $set, string $url)
    {
        
        $path = __DIR__."/../public/img/category/$url";
        if(!is_dir($path))
        {
            mkdir($path);
            mkdir($path."/image");
            mkdir($path."/image/thumb");
        }

        if(($_FILES["image"]["size"] > 0))
        {
            $this->uploader->uploadImage("image", __DIR__."/../public/img/category/$url/image", "main", "png");
        }

        // update row
        $this->database->update($this->model_table, $set, "url=?", [$url]);


    }
    
    public function deletePortfolioCategory(string $url)
    {
        // delete row
        $this->database->update($this->table, ["category_url"=>"nezarazene"], "category_url=?", [$url]);
        $this->database->delete($this->model_table, "url=?", [$url]);
    }

    public function deletePortfolioCategoryByType(string $type)
    {
        // delete row
        return $this->database->delete($this->model_table, "portfolio_type=?", [$type]);
    }

    public function deletePortfolioCategoryData(string $url)
    {
        $path = __DIR__."/../public/img/category/$url";
        if(is_dir($path))
        {
            //delete thumbs
            foreach(glob($path."/image/thumb/*") as $thumbs)
            {
                unlink($thumbs);
            }
            rmdir($path."/image/thumb");

            //delete images
            foreach(glob($path."/image/*") as $images)
            {
                unlink($images);
            }
            rmdir($path."/image");

            //Delete folder
            rmdir($path);

            return true;
        }
    }


} 

