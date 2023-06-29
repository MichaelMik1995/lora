<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
use App\Core\Lib\Uploader;
//Module Model  


class ManagerProductController extends MshopController 
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
    protected $uploader;
    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        $this->model = $model;
        $this->uploader = new Uploader();
    }
    
    
    public function index() 
    {
      
        $this->title = "Manager Product";
         $products = $this->model["product"]->getAllProducts("visibility ASC");
                
                $this->data = [
                    "products" => $products,
                ];     
                
        $this->view = "manager/product/index";
    }
    
    public function show()
    {
        $route_param = $this->u["param"];
        $get_one = $this->model["product"]->getProduct($route_param); //Getting one row from table

        $this->data = [
            "product" => $get_one,
            "easy_text" => $this->injector["Easytext"],                         //!!!EDIT
            "number_utils" => $this->injector["NumberUtils"],
            "discussions" => $this->model["disscussion"]->getAll(),
            "user_uid" => @$this->injector["Auth"]->user_uid,
            "ip" => $_SERVER["REMOTE_ADDR"],
        ];

        $this->view = "manager/product/show";
    }
    
    public function create()
    {
        $form = $this->injector["Easytext"]->form("description", "", ["height"=>"15em", "max_chars"=>2048, "hide_submit"=>1]);
                
        $this->data = [
          "form" => $form,
            "categories" => $this->model["category"]->getAll(),
            "database" => $this->injector["Database"],                                  //!!! EDIT
        ];

        $this->view = "manager/product/create"; 
    }
    
    public function insert()
    {
        $validation = $this->injector["Validation"];
        
        
        $name = $validation->input("name");
        $price = floatval($validation->input("price"));
        $stock = intval($validation->input("stock"));
        $cat_sub_egory = explode("/", $validation->input("category"));
        $category = $cat_sub_egory[0];
        $subcategory = $cat_sub_egory[1];
        $short_desc = $validation->input("sh_desc");
        $description = $validation->input("description");
        $sizes = $validation->input("sizes");

        $validation->validate($name, ["required"]);
        $validation->validate($price, ["required"]);
        $validation->validate($stock, ["required", "int"]);
        $validation->validate($category, ["required", "url"]);
        $validation->validate($subcategory, ["required", "url"]);
        $validation->validate($short_desc, ["required"]);
        $validation->validate($description, ["string"]);
        $validation->validate($sizes, ["max_chars2048"]);

        $stock_code = substr(hash("sha256", md5("SwipeCTime".time())), 0, 10);

        if($validation->isValidated() == true)
        {
            try {
                $create_image_folder = "App/Modules/MshopModule/resources/img/product/$stock_code";
                $create_image_thumb_folder = "App/Modules/MshopModule/resources/img/product/$stock_code/thumb";
                if(!file_exists($create_image_folder) && !file_exists($create_image_thumb_folder))
                {
                    mkdir($create_image_folder);
                    mkdir($create_image_thumb_folder);

                    $this->uploader->upload_dir = "App/Modules/MshopModule/resources/img/";
                    $this->uploader->uploadImage("main_image", "product/$stock_code", "main", "png");
                    
                    
                    @$this->uploader->uploadImages("images", "product/$stock_code");


                }

                $this->model["product"]->insertProduct([
                        "product_name" => $name,
                        "price" => $price,
                        "quantity" => $stock,
                        "stock_code" => $stock_code,
                        "short_description" => $short_desc,
                        "description" => $description,
                        "category" => $category,
                        "sizes" => $sizes,
                        "subcategory" => $subcategory,
                        "created_at" => time(),
                        "updated_at" => time(),
                    ]);

                    $this->injector["LoraException"]->successMessage("Produkt $name byl přidán!");
                    $this->redirect("mshop/manager/products");

            } catch (LoraException $ex) {

                @rmdir("./public/img/mshop/product/$stock_code");
                @rmdir("./public/img/mshop/product/$stock_code/thumb");

                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Nelze přidat produkt! Nevalidní data!");
        }
    }
    
    public function edit()
    {
        $stock_code = $this->u["param"];
        $get_one = $this->model["product"]->getProduct($stock_code);
        $form = $this->injector["Easytext"]->form("description", $get_one["description"], ["height"=>"25em", "max_chars"=>2048, "hide_submit"=>1]);

        $this->data = [
          "product" => $get_one, 
            "form" => $form,
        ];

        $this->view = "manager/product/edit";
    }
    
    public function update()
    {
        $validation = $this->injector["Validation"];
        
        $stock_code = $validation->input("stock_code");   
        $product_name = $validation->input("name");
        $product_type = intval($validation->input("type"));
        $short_description = $validation->input("sh_desc");
        $description = $validation->input("description");
        $price = floatval($validation->input("price"));
        $in_Stock = intval($validation->input("stock"));
        $is_action = intval($validation->input("is_action"));
        $action_price = floatval($validation->input("action_price"));
        $grouping = intval($validation->input("grouping"));
        $visibility = intval($validation->input("visibility"));
        $recommended = intval($validation->input("recommended"));
        $sizes = $validation->input("sizes");
        

        //Validate form data
        $validation->validate($stock_code,["required", "string", "chars8-16"], "Produktový kód");
        $validation->validate($product_name,["required","string"], "Název");
        $validation->validate($product_type,["required", "int"], "Typ");
        $validation->validate($short_description,["required", "string"], "Krátký popis");
        $validation->validate($description, ["string"], "Podrobnosti produktu");
        $validation->validate($price,["required"], "Cena");
        $validation->validate($in_Stock, ["required", "int"], "Skladem");
        $validation->validate($is_action,["required", "int"], "Sleva");
        $validation->validate($action_price,["required"], "Cena ve slevě");
        $validation->validate($grouping,["required", "int"], "Typ množství");
        $validation->validate($visibility,["required", "int"], "Publikace produktu");
        $validation->validate($recommended,["required", "int"], "Doporučení produktu");
        $validation->validate($sizes, ["max_chars2048"]);

        if($validation->isValidated() == true)
        {
            try {

                $this->model["product"]->updateProduct($stock_code, [
                    "product_name" => $product_name,
                    "type" => $product_type,
                    "price" => $price,
                    "quantity" => $in_Stock,
                    "grouping" => $grouping,
                    "visibility" => $visibility,
                    "is_action" => $is_action,
                    "action_prize" => $action_price,
                    "in_stock" => $in_Stock,
                    "sizes" => $sizes,
                    "is_action" => $is_action,
                    "short_description" => $short_description,
                    "recommended" => $recommended,
                    "description" => $description,
                    "updated_at" => time(),
                ]);
                $this->redirect("mshop/manager/products");
            } catch (LoraException $ex) {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
                $this->redirect("/mshop/manager/product-edit/$stock_code");
            }
        }
    }
    
    public function delete()
    {
        $validation = $this->injector["Validation"];
        
        $stock_code = $validation->input("stock_code");
                
        $validation->validate($stock_code, ["string", "required"]);

        if($validation->isValidated() == true)
        {
            try {
                $this->model["product"]->deleteProduct($stock_code);
                $this->injector["LoraException"]->successMessage("Produkt byl smazán");

                $this->redirect("mshop/manager/products");
            } catch (LoraException $ex) {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
                $this->redirect("/mshop/manager/product-edit/$stock_code");
            }
        }
        else
        {
            $this->injector["LoraException"]->errorMessage("Produkt nebyl smazán!");
            $this->redirect("/mshop/manager/product-edit/$stock_code");
        }
    }
    
    public function addImages()
    {
        $validation = $this->injector["Validation"];
        
        $stock_code = $validation->input("stock_code");
                
        $validation->validate($stock_code, ["required", "string"]);

        if($validation->isValidated() == true)
        {
            try {

                $this->uploader->upload_dir = "App/Modules/MshopModule/resources/img/";
                $this->uploader->uploadImages("images", "product/$stock_code");
            } catch (LoraException $ex) {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
        }

        $this->redirect("mshop/manager/product-edit/$stock_code");
    }
    
    public function imageDelete()
    {
        $validation = $this->injector["Validation"];    
        
        $image = $validation->input("image_file");
        $stock_code = $validation->input("stock_code");

        $validation->validate($image, ["required","string"]);
        $validation->validate($stock_code, ["required","string"]);

        if($validation->isValidated() == true)
        {

            unlink($image);
            $thumb = str_replace("/thumb", "", $image);
            unlink($thumb);

            $this->injector["LoraException"]->successMessage("Obrázek smazán");
            $this->redirect("mshop/manager/product-edit/$stock_code");
        }
    }
    
    public function saveTempMainImage()
    {
        
    }
}

