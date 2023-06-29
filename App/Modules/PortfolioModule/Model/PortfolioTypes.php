<?php
/**
 * Description of Module Model - PortfolioTypes:
 *
 * This model was created for module: Portfolio
 * @author MiroJi
 * Created_at: 1675172687
 */
declare (strict_types=1);

namespace App\Modules\PortfolioModule\Model;

/**
*   Using main module Model
*/
use App\Exception\LoraException;
use App\Modules\PortfolioModule\Model\Portfolio;
use App\Modules\PortfolioModule\Model\PortfolioCategory;
use App\Modules\PortfolioModule\Model\PortfolioItem;

use App\Core\Lib\Uploader;

class PortfolioTypes extends Portfolio
{

    protected $model_table = "portfolio-types";

    protected Uploader $uploader;
    public function __construct()
    {
        parent::__construct();
        $this->uploader = new Uploader();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllPortfolioTypes(string $order_by = "id ASC"): Array
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
    public function getAllPortfolioTypesCategories(string $order_by = "id ASC"): Array
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
                $type_url = $row["url"];
                
                $db_query[$id]["_description"] = $this->easy_text->translateText($content);
                $db_query[$id]["categories"] = $this->database->select("portfolio-categories", "portfolio_type=?", [$type_url]);
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
    public function getPortfolioTypes(string $url): Array
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
    
    public function insertPortfolioTypes(array $insert_values, string $url)
    {
        // Insert new row
        $this->database->insert($this->model_table, $insert_values);
            //create type folder if not exists
            $type_folder = __DIR__ . "/../public/img/type/$url";
            if(!is_dir($type_folder))
            {
                mkdir($type_folder);
                mkdir($type_folder . "/image");
                mkdir($type_folder . "/image/thumb");
            }

            $image_path = __DIR__ . "/../public/img/type/$url/image";

            if(!empty($_FILES["image"]["name"]))
            {
                if (file_exists($image_path . "/main.png"))
                {
                    unlink($image_path . "/image/thumb/main.png");
                    unlink($image_path . "/image/main.png");
                }

                $this->uploader->uploadImage("image", $image_path, "main", "png");
            }
            return true;
    }
    
    public function updatePortfolioTypes(array $set, string $url)
    {
        // update row
        $this->database->update($this->model_table, $set, "url=?", [$url]);

        $type_folder = __DIR__ . "/../public/img/type/$url";
            if(!is_dir($type_folder))
            {
                mkdir($type_folder);
                mkdir($type_folder . "/image");
                mkdir($type_folder . "/image/thumb");
            }

        $image_path = __DIR__ . "/../public/img/type/$url/image";
        if(!empty($_FILES["image"]["name"]))
        {
            if (file_exists($image_path . "/main.png"))
            {
                unlink($image_path . "/thumb/main.png");
                unlink($image_path . "/main.png");
            }

            $this->uploader->uploadImage("image", $image_path, "main", "png");
        }
    }
    
    public function deletePortfolioTypes(PortfolioCategory $category, PortfolioItem $item, string $url)
    {
        

        //move items to uncategorized
        $select_categories = $this->database->select($this->table_categories, "portfolio_type=?", [$url]);
        if(!empty($select_categories))
        {
            $categories = "";
            foreach($select_categories as $category_row)
            {
                $category_url = $category_row["url"];
                $categories .= "category_url='$category_url' OR ";

                $category->deletePortfolioCategoryData($category_url);

            }

            $where_query = rtrim($categories, "OR ");
            
            $this->database->update($this->table, ["category_url"=>"nezarazene"], "id!=? AND ($where_query)", [0]);
            

            //delete categories

            $category->deletePortfolioCategoryByType($url);

            //delete portfolio
            $this->database->delete($this->model_table, "url=?", [$url]);

            $path = __DIR__."/../public/img/type/$url";
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
            }
        }
        
    }


} 

