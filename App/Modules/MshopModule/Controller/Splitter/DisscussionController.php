<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class DisscussionController extends MshopController 
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
    
    
    public function index() 
    {
      
    }
    
    public function insert()
    {
        $validation = $this->injector["Validation"];
        
        $title = $validation->input("discussion-header");
        $content = $validation->input("discussion-text");
        $product_url = $validation->input("product-url");
        $for_company = @$validation->input("discussion-ask-company");

        $validation->validate($title, ["max_chars128", "required"], "Název");
        $validation->validate($content, ["max_chars2048", "required"], "Obsah");
        $validation->validate($product_url, ["max_chars64", "url"], "Katalogové číslo");

        if(isset($for_company))
        {
            $for_company = 1;
        }
        else
        {
            $for_company = 0;
        }

        if($this->injector["Auth"]->isLogged() == true)
        {
            $user = $this->injector["Auth"]->user_uid;
            $email = "";
        }
        else
        {
            $name = $validation->input('discussion-author');
            $email = $validation->input('discussion-email');
            $user = $name;
        }


        if($validation->isValidated() == true)
        {
            try {
                $this->model["disscussion"]->insert([
                    "url" => $product_url,
                    "author" => $user,
                    "title" => $title,
                    "content" => $content,
                    "for_company" => $for_company,
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);

                $this->injector["LoraException"]->successMessage("Vlákno bylo přidáno!");
                $this->injector["Logger"]->log("Disscussion threat added to product: $product_url", "SUCCESS:DISSCUSSION_CREATE");
            } catch (LoraException $ex) {
                $this->injector["Logger"]->log("Disscussion threat not created to product: $product_url. REASON-> ".$ex->getMessage(), "FAILED:DISSCUSSION_CREATE");
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }


        }

        $this->redirect("mshop/shop/product-show/$product_url");
    }
    
    public function addComment()
    {
        $validation = $this->injector["Validation"];
        
        $content = $validation->input('cmt-content');
        $diss_id = $this->u["param"];
        
        $product_code = $validation->input("product_code");

        if($this->injector["Auth"]->isLogged() == false)
        {
            $name = $validation->input('cmt-name');

        }
        else
        {
            $name = $this->injector["Auth"]->user_name;
        }

        $validation->validate($name, ["max_chars64"], "Jméno");
        $validation->validate($content, ["required","max_chars2048"], "Komentář");
        $validation->validate($product_code, ["required", "url", "max_chars32"], "ID produktu");

        if($validation->isValidated() == true)
        {
            try {
                $this->model["disscussion"]->insertComment([
                    "disscussion_id" => $diss_id,
                    "author" => $name,
                    "content" => $content,
                    "created_at" => time(),
                    "updated_at" => time()
                ]);
                
                $this->injector["Logger"]->log("Comment to disscussion: $diss_id added to product: $product_code", "SUCCESS:DISSCUSSION_COMMENT_CREATE");
                $this->injector["LoraException"]->successMessage("Komentář k diskuzi byl přidán");

            } catch (Exception $ex) {
                
                $this->injector["Logger"]->log("Comment to disscussion: $diss_id added to product: $product_code", "FAILED:DISSCUSSION_COMMENT_CREATE");
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }

        }

        $this->redirect("mshop/shop/product-show/$product_code");
    }
}

