<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;
use App\Core\Model;

use App\Core\Lib\EmailSender;

/**
 * Description of ProductDiscussion module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class ProductDiscussion extends Model {

    protected $table = "mshop-product-discussion";

    public function __construct(string $route_param = null) {
        $this->init();
        if ($route_param != null) {
            $this->database->route_param = $route_param;
        }

        $this->database->table = $this->table; //Uncheck if table name is not like controller name
    }

    public function getAll(string $order_by = "id ASC") 
    {
        return $this->database->select($this->table, "solved=? ORDER BY $order_by", [0]);
    }
    
    public function getForManager(string $order_by = "id ASC")
    {
        return $this->database->select($this->table, "solved=? AND for_company=? AND answered=? ORDER BY $order_by", [0, 1, 0]);
    }
    
    public function getByUrl($url, string $order_by = "id ASC") 
    {
        $db_query = $this->database->select($this->table, "url=? ORDER BY $order_by", [$url]);
        
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $get_id = $row['id'];
                
                $comments = $this->database->select("mshop-product-discussion-comments", "disscussion_id=?", [$get_id]);
                
                if(!empty($comments))
                {
                    $db_query[$id]['comments'] = $comments;
                }
                else
                {
                    $db_query[$id]['comments'] = [];
                }
            }
            return $db_query;
        }
        else{
            return [];
        }
    }

    public function get($disscussion_id="") 
    {
        if($disscussion_id == "")
        {
          return $this->database->tableRowByRoute();  
        }
        else
        {
            return $this->database->selectRow("mshop-product-discussion", "id=?", [$disscussion_id]);
        }
    }

    public function insert(array $values) 
    {
        return $this->database->tableInsertByRoute($values);
    }
    
    public function insertComment(array $values)
    {
        $diss_id = $values["disscussion_id"];
        
        $this->database->insert("mshop-product-discussion-comments", $values);
        $this->database->update("mshop-product-discussion", ["answered"=>"1"], "id=?", [$diss_id]);
    }
    
    public function sendNotification($disscussion_id, $email_to, $product_code, $product_name)
    {
        $get = file_get_contents("./App/Modules/MshopModule/resources/templates/email/add_comment_disscussion.phtml");
        
        $email_sender = new EmailSender();
        
        $email_sender->template_path = "./App/Modules/MshopModule/resources/templates/email";
        
        $email_sender->send($email_to, "Komentář k Vašemu dotazu", "add_comment_disscussion", [
            "{product-name}" => $product_name,
            "{company-name}" => $this->config->var("WEB_NAME"),
            "{host}" => $this->config->var("WEB_ADDRESS"),
            "{product-code}" => $product_code,
            "{disscussion-id}" => $disscussion_id
        ]);
        
        
    }

    public function update(array $set) 
    {
        return $this->database->tableUpdateByRoute($set);
    }

    public function delete() 
    {
        return $this->database->tableDeleteByRoute();
    }
    
    private function countDiscussionOfProduct($product_code)
    {
        return count($this->database->select($this->table, "url=?", [$product_code]));
    }

}
