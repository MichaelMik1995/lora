<?php
/**
 * Description of Module Model - AdminAnnouncements:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1690261644
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;
use App\Core\Database\Database;

//Interface
use App\Core\Interface\ModelDBInterface;

//Core
use App\Core\DI\DIContainer;

class AdminAnnouncements extends Admin implements ModelDBInterface
{
    protected $model_table = "announcements";
    protected $database;

    public function __construct(DIContainer $container, Database $database) //Can expand to multiple arguments, first must be DIContainer
    {
        parent::__construct($container);    //Only this one argument is needed

        $this->database = $database;
        $this->database->table = $this->model_table;      //Uncheck this, if table is different from controller name
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllAdminAnnouncements(string $order_by = "id ASC"): Array
    {
        $db_query = $this->database->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
        if(!empty($db_query))
        {
            $return_array = [];
            $i = 0;
            
            foreach($db_query as $row)
            {
                $id = $i++;
                
                //Filter indexes from $row
                $return_array[$id] = array_filter($row, "is_string", ARRAY_FILTER_USE_KEY);
                
                $content = $row["content"];
                
                $return_array[$id]["_content"] = $this->easy_text->translateText($content);
            }
            
            return $return_array;
        }
        else
        {
            return [];
        }
    }

    /**
     * Returns rows computed by $limit_per_page variable
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table test</p>
     */
    public function getAllByPage(int|string $page = 1, int $limit_per_page = 25, string $order_by = "id DESC"): Array
    {

        $computed_limit = (($page - 1)*$limit_per_page. ", " .$limit_per_page);

        $db_query = $this->database->tableAllData("id DESC", $computed_limit);
        
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                //$tags = $row["tags"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                //$db_query[$id]["_tags"] = ArrayUtils::charStringToArray($tags);
            }
            
            return $db_query;
        }
        else
        {
            return [];
        }

    }

    public function getavaliablePages(int $limit_per_page = 25)
    {
        //Count CEIL of avaliable pages
        $count_rows = $this->database->countRows($this->model_table, "id!=?", [0]);   //100
        $avaliable_pages = ceil($count_rows / $limit_per_page); //100 / 20 = 5
        return $avaliable_pages;
    }
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function getAdminAnnouncements(string $url): Array
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
    
    public function insertAdminAnnouncements(array $insert_values)
    {
        // Insert new row
        return $this->database->insert($this->model_table, $insert_values);
    }
    
    public function updateAdminAnnouncements(array $set, string $url)
    {
        // update row
        return $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteAdminAnnouncements(string $url)
    {
        // delete row
        return $this->database->delete($this->model_table, "url=?", [$url]);
    }

    /** MAGICAL METHODS **/
    public function __set($name, $value) {
        $this->model_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->model_data[$name])) {
            return $this->model_data[$name];
        }
        return null;
    }
} 

