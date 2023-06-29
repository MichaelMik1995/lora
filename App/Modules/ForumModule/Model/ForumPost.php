<?php
/**
 * Description of Module Model - ForumPost:
 *
 * This model was created for module: Forum
 * @author MiroJi
 * Created_at: 1678270272
 */
declare (strict_types=1);

namespace App\Modules\ForumModule\Model;
use App\Modules\ForumModule\Model\ForumComment;

/**
*   Using main module Model
*/
use App\Modules\ForumModule\Model\Forum;

class ForumPost extends Forum
{

    protected $model_table = "forum-posts";

    protected ForumComment $forum_comment;

    public function __construct(ForumComment $comments = null)
    {
        parent::__construct();
        $this->forum_comment = $comments;
    }

    /**
     * 
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllForumPost(string $order_by = "id ASC"): Array
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
     * @param string $order_by <p>Order tables in rows (ex.: id ASC)</p>
     * @return object <p>Returns all rows from table {model_name}</p>
     */
    public function getAllForumPostByCategory(string $theme_url, string $category_url, string $order_by = "id ASC"): Array
    {
        $db_query = $this->db->select($this->model_table, "id!=? AND (category_url LIKE '%$theme_url%') ORDER BY $order_by", [0]);
        if(!empty($db_query))
        {
            $returnArray = [];


            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $content = $row["content"];
                $category = $row["category_url"];
                $explode = explode("@", $category);
                $cat_url = $explode[1];
                $url = $row["url"];

                if($category_url == $cat_url)
                {
                    $returnArray[$id] = $row;
                    $returnArray[$id]["_content"] = $this->easy_text->translateText($content);
                    $returnArray[$id]["comments_count"] = $this->db->countRows($this->table_post_comments, "post_url=?", [$url]);
                }
            }
            
            return $returnArray;
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
    public function getForumPost(string $url): Array
    {
        $db_query = $this->db->selectRow($this->model_table, "url=?", [$url]);
        if(!empty($db_query))
        {
            $content = $db_query["content"];
            $post_url = $db_query["url"];
            
            $db_query["_content"] = $this->easy_text->translateText($content);
            $db_query["comments"] = $this->forum_comment->getAllForumComment($post_url);//$this->db->select($this->table_post_comments, "post_url=?", [$post_url]);
            $db_query["comments_count"] = count($db_query["comments"]); 
            
            return $db_query;
        }
        else
        {
            return [];
        }
    }
    
    public function insertForumPost(array $insert_values)
    {
        // Insert new row
        return $this->db->insert($this->model_table, $insert_values);
    }
    
    public function updateForumPost(array $set, string $url)
    {
        // update row
        return $this->db->update($this->model_table, $set, "url=?", [$url]);
    }
    
    public function deleteForumPost(string $url)
    {
        // delete row
        return $this->db->delete($this->model_table, "url=?", [$url]);
    }

    public function closeForumPost(string $url)
    {
        return $this->db->update($this->model_table, ["solved"=>1], "url=?", [$url]);
    }

    public function openForumPost(string $url)
    {
        return $this->db->update($this->model_table, ["solved"=>0], "url=?", [$url]);
    }


} 

