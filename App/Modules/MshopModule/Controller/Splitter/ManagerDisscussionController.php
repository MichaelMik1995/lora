<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerDisscussionController extends MshopController 
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
        $get_all = $this->model["disscussion"]->getForManager("for_company DESC");
                
                $this->data = [
                    "all" => $get_all,
                ];
                
                $this->title = "";
                $this->view = "manager/product/discussion/index";
    }
    
    public function addComment()
    {
        $validation = $this->injector["Validation"];
        $exception = $this->injector["LoraException"];
        
        $disscussion_id = intval($this->u["param"]);  
        $content = $validation->input("content");
        
        $disscussion = $this->model["disscussion"]->get($disscussion_id);
        
        
        
        $validation->validate($disscussion_id, ["required", "int"], "ID Diskuze");
        $validation->validate($content, ["required", "max_chars2048"], "Obsah");
        
        if($validation->isValidated() == true)
        {
            try {
                $parse = parse_ini_file("./config/public.ini");
                $this->model["disscussion"]->insertComment([
                    "disscussion_id" => $disscussion_id,
                    "author" => $parse["WEB_NAME"],
                    "content" => $content,
                    "from_company" => "1",
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);
                
                $product = $this->model["product"]->getProduct($disscussion["url"]);
                if($disscussion["author"] != null && str_contains($disscussion["author"], "@"))
                {
                    $this->model["disscussion"]->sendNotification($disscussion_id, $disscussion["author"], $disscussion["url"], $product["product_name"]);
                }
                
                
                $exception->successMessage("Komentář byl přidán");
            } catch (Exception $ex) {
                $exception->errorMessage($ex->getMessage());
            }
        }
        
        $this->redirect("mshop/manager/product-discussion");
    }
}

