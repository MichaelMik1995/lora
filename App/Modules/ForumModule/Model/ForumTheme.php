<?php
/**
 * Description of Module Model - ForumTheme:
 *
 * This model was created for module: Forum
 * @author MiroJi
 * Created_at: 1678270272
 */
declare (strict_types=1);

namespace App\Modules\ForumModule\Model;

/**
*   Using main module Model
*/
use App\Modules\ForumModule\Model\Forum;
use App\Modules\ForumModule\Model\ForumThemeCategory;

class ForumTheme extends Forum
{

    protected $model_table = "forum-themes";
    protected $forum_category;

    public function __construct(ForumThemeCategory $forum_category = null)
    {
        parent::__construct();

        $this->forum_category = $forum_category;
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllForumTheme(string $order_by = "id ASC", $limit = 8): Array
    {
        $db_query = $this->db->select($this->model_table, "id!=? ORDER BY $order_by", [0]);
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $url = $row["url"];
                
                $db_query[$id]["_content"] = $this->easy_text->translateText($content);
                $db_query[$id]["categories"] = $this->forum_category->getForumThemesCategory($url, $limit);
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
    public function getForumTheme(string $url): Array
    {
        $db_query = $this->db->selectRow($this->model_table, "url=?", [$url]);
        if(!empty($db_query))
        {
            $content = $db_query["content"];
            
            $db_query["_content"] = $this->easy_text->translateText($content);
            $db_query["categories"] = $this->forum_category->getForumThemesCategory($url, 50);
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insertForumTheme(array $insert_values)
    {
        // Insert new row
        return $this->db->insert($this->model_table, $insert_values);
    }
    
    public function updateForumTheme(array $set, string $url)
    {
        // update row
        return $this->db->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteForumTheme(string $url)
    {
        // delete row
        $get_category = $this->db->selectRow($this->table_theme_categories, "theme_url=?", [$url]);

        //delete all posts 
        $this->db->delete($this->table_posts, "(category_url LIKE '%$url%') AND (category_url LIKE '%".$get_category["url"]."%')");

        //Delete categories
        $this->db->delete($this->table_theme_categories, "theme_url=?", [$url]);

        return $this->db->delete($this->model_table, "url=?", [$url]);
    }


} 

