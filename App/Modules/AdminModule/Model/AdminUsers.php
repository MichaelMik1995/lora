<?php
/**
 * Description of Module Model - AdminUsers:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1684328161
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;
use App\Core\Lib\Utils\ArrayUtils;
use App\Core\Interface\ModelDBInterface;
use App\Core\DI\DIContainer;

class AdminUsers extends Admin implements ModelDBInterface
{

    protected $model_table = "users";
    private array|null $model_data = [];

    public function __construct(DIContainer $container)
    {
        parent::__construct($container);      
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllUsers(string $order_by = "id ASC"): Array
    {
        $db_query = $this->db->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
        if(!empty($db_query))
        {
            $return_array = [];
            $i = 0;
            
            foreach($db_query as $row)
            {
                $id = $i++;
                $uid = $row["uid"];
                $is_admin = $this->db->selectRow("role-id", "user_uid=? AND role_slug=?", [$uid, "admin"]);
                
                if(!empty($is_admin))
                {
                    $row["is_admin"] = true;
                }
                else
                {
                    $row["is_admin"] = false;
                }
                
                //Filter indexes from $row
                $return_array[$id] = array_filter($row, "is_string", ARRAY_FILTER_USE_KEY); 
            }
            $this->model_data = $return_array;
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
    public function getUser(string|int $uid): Array
    {
        $db_query = $this->db->selectRow($this->model_table, "uid=?", [$uid]);
        if(!empty($db_query))
        {            
            $is_admin = $this->db->selectRow("role-id", "user_uid=? AND role_slug=?", [$uid, "admin"]);
                
                if(!empty($is_admin))
                {
                    $db_query["is_admin"] = true;
                }
                else
                {
                    $db_query["is_admin"] = false;
                }

            return $db_query;
        }
        else
        {
            $this->model_data = null;
            return [];
        }
    }
    
    public function insertUser(array $insert_values)
    {
        // Insert new row
        return $this->db->insert($this->model_table, $insert_values);
    }
    
    public function updateUser(array $set, string $url)
    {
        // update row
        return $this->db->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteUser(string $url)
    {
        // delete row
        return $this->db->delete($this->model_table, "url=?", [$url]);
    }

    public function verifyUser(int|string $uid)
    {
        return $this->db->update($this->model_table, ["email_verified_at"=>time()], "uid=?", [$uid]);
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

