<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
use App\Modules\MshopModule\Model\MshopFinder;
//Module Model  


class MshopFinderController extends MshopController 
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
    protected $main_model;

    
    public function __construct($injector)
    {
        parent::__construct($injector);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        $this->main_model = new MshopFinder();
    }
    
    
    public function find()
    {
        $this->title = "Vyhledávám ...";
        
        $validation = $this->injector["Validation"];
        $key_word = $validation->input("search-string");
           
        
        $validation->validate($key_word, ["required", "maxchars128", "string"]);


        
        if($validation->isValidated() == true)
        {
            try {
                    $this->data = [
                    "search_string" => $key_word,
                    "number_utils" => $this->injector["NumberUtils"],
                    "ip" => $_SERVER["REMOTE_ADDR"],
                    "products" => $this->main_model->getAll($key_word),  
                ];
                    
                $this->injector["LoraException"]->successMessage("Vyhledána fráze: ".$key_word);
            } catch (LoraException $ex) {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
            

            

            $this->view = "finder/index";
        }
    }
}

