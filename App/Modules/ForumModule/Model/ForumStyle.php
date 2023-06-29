<?php
/**
 * Description of Module Model - ForumStyle:
 *
 * This model was created for module: Forum
 * @author MiroJi
 * Created_at: 1678271809
 */
declare (strict_types=1);

namespace App\Modules\ForumModule\Model;

/**
*   Using main module Model
*/
use App\Modules\ForumModule\Model\Forum;

class ForumStyle extends Forum
{

    protected $model_table = "forum-styles";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllForumStyle(string $order_by = "id ASC"): Array
    {
        $db_query = $this->db->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
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
    public function getForumStyle(string $url): Array
    {
        $db_query = $this->db->selectRow($this->model_table, "url=?", [$url]);
        if(!empty($db_query))
        {
            //$content = $db_query["content"];
            
            // $db_query["_content"] = $this->easy_text->translateText($content);
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insertForumStyle(array $insert_values)
    {
        // Insert new row
        return $this->db->insert($this->model_table, $insert_values);
    }
    
    public function updateForumStyle(array $set, string $url)
    {
        // update row
        return $this->db->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteForumStyle(string $url)
    {
        // delete row
        return $this->db->delete($this->model_table, "url=?", [$url]);
    }


} 

