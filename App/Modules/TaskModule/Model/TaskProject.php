<?php
/**
 * Description of Module Model - TaskProject:
 *
 * This model was created for module: Task
 * @author MiroJi
 * Created_at: 1687674114
 */
declare (strict_types=1);

namespace App\Modules\TaskModule\Model;

/**
*   Using main module Model
*/
use App\Modules\TaskModule\Model\Task;

class TaskProject extends Task
{

    protected $model_table = "TaskProject";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllTaskProject(string $order_by = "id ASC"): Array
    {
        $db_query = $this->db->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
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
    public function getAllByPage(int|string $page = 1, int $limit_per_page = 25, string $order_by = "id ASC"): Array
    {

        $computed_limit = (($page - 1)*$limit_per_page. ", " .$limit_per_page);

        $db_query = $this->db->tableAllData("id", $computed_limit);
        
        if(!empty($db_query))
        {
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $tags = $row["tags"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["_tags"] = ArrayUtils::charStringToArray($tags);
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
        $count_rows = $this->db->countRows($this->table, "id!=?", [0]);   //100
        $avaliable_pages = ceil($count_rows / $limit_per_page); //100 / 20 = 5
        return $avaliable_pages;
    }
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function getTaskProject(string $url): Array
    {
        $db_query = $this->db->selectRow($this->model_table, "url=?", [$url]);
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
    
    public function insertTaskProject(array $insert_values)
    {
        // Insert new row
        return $this->db->insert($this->model_table, $insert_values);
    }
    
    public function updateTaskProject(array $set, string $url)
    {
        // update row
        return $this->db->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteTaskProject(string $url)
    {
        // delete row
        return $this->db->delete($this->model_table, "url=?", [$url]);
    }


} 

