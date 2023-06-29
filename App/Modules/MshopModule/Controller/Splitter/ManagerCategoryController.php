<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerCategoryController extends MshopController 
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
        $get_categories = $this->model["category"]->getAll();
                
        $this->data = [
          "categories" => $get_categories,
        ];

        $this->view = "manager/category/index";
    }
    
    public function categoryInsert()
    {
        $validation = $this->injector["Validation"];
        $lora_exception = $this->injector["LoraException"];
        
        $name = $validation->input("name");
        $slug = $this->injector["StringUtils"]->toSlug($name);

        $validation->validate($name, ["required", "string"]);
        $validation->validate($slug, ["required", "url"]);

        if($validation->isValidated() == true)
        {
            try{

                $this->model["category"]->insert([
                    "category_name" => $name,
                    "category_slug" => $slug,
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);
                $lora_exception->successMessage("Kategorie $name přidána!");
                $this->redirect("mshop/manager/category");
            } catch (LoraException $ex) {
                $lora_exception->errorMessage($ex->getMessage());
            }
        }
        else
        {
            $lora_exception->errorMessage("Nebylo možné přidat novou kategorii!");
        }
    }
    
    public function categoryDelete()
    {
        $validation = $this->injector["Validation"];
        $lora_exception = $this->injector["LoraException"];
        
        $slug = $validation->input("category");
        $validation->validate($slug, ["url", "required"]);

        if($validation->isValidated() == true)
        {
            try{
                $this->model["category"]->deleteCategory($slug);
                $lora_exception->successMessage("Kategorie smazána!");
                
            } catch (LoraException $ex) 
            {
                $lora_exception->errorMessage($ex->getMessage());
            }
        }
        else
        {
            $lora_exception->errorMessage("Nebylo možné přidat novou kategorii!");
        }
        
        $this->redirect("mshop/manager/category");
    }
    
    public function SubcategoryInsert()
    {
        $validation = $this->injector["Validation"];
        $lora_exception = $this->injector["LoraException"];
        
        $name = $validation->input("name");
        $slug = $this->injector["StringUtils"]->toSlug($name);
        $category_id = $validation->input("category");

        $validation->validate($name, ["required", "string"]);
        $validation->validate($slug, ["required", "url"]);
        $validation->validate($category_id, ["required", "url"]);

        if($validation->isValidated() == true)
        {
            try{

                $this->model["category"]->addSub($name, $slug, $category_id);
                $lora_exception->successMessage("Podkategorie $name přidána!");

            } catch (LoraException $ex) {
                $lora_exception->errorMessage($ex->getMessage());
            }
        }
        else
        {
            $lora_exception->errorMessage("Nebylo možné přidat novou kategorii!");
        }

        $this->redirect("mshop/manager/category");
    }
    
    public function subcategoryDelete()
    {
        $validation = $this->injector["Validation"];
        $lora_exception = $this->injector["LoraException"];
        
        $slug = $validation->input("subcategory");
        $validation->validate($slug, ["url", "required"]);

        if($validation->isValidated() == true)
        {
            try{
                $this->model["category"]->deleteSub($slug);
                $lora_exception->successMessage("Podkategorie smazána!");
                $this->redirect("mshop/manager/category");
            } catch (LoraException $ex) {
                $lora_exception->errorMessage($ex->getMessage());
            }
        }
        else
        {
            $lora_exception->errorMessage("Nebylo možné smazat podkategorii!");
        }
    }
}

