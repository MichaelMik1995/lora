<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class MshopReviewController extends MshopController 
{
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    public function insert() 
    {
        $validation = $this->injector["Validation"];
        
        
        $product_code = $validation->input("product-code");
        $eval_rate = $validation->input("rating");
        $review_user = $validation->input("review-user");
        
        
        if(isset($review_user))
        {
            $user = $review_user;
        }
        else
        {
            if($this->injector["Auth"]->isLogged() == true)
            {
                $user = $this->injector["Auth"]->user_uid;
            }
            else
            {
                $user = "-1";
            }  
        }
        
        $content = $validation->input("review-text");
        $plus = $validation->input("review-plus");
        $minus = $validation->input("review-minus");
        
        $validation->validate($product_code, ["required", "max_"], "ID produktu");
        $validation->validate($eval_rate, ["required", "int"], "Hodnocení");
        $validation->validate($content, ["required","max_chars2048"], "Obsah");
        $validation->validate($plus, ["max_chars512"], "Klady");
        $validation->validate($minus, ["max_chars512"], "Nedostatky");
        
        if($validation->isValidated() == true)
        {
            try {
                $this->model["review"]->insert([
                    "product_code" => $product_code,
                    "author" => $user,
                    "content" => $content,
                    "plus" => $plus,
                    "minus" => $minus, 
                    "rank" => $eval_rate,
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);
                
                $this->injector["LoraException"]->successMessage("Hodnocení přidáno!");
                
            } catch (Exception $ex) {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
            
            
        }
        
        $this->redirect("mshop/shop/product-show/$product_code");
        
    }
}

