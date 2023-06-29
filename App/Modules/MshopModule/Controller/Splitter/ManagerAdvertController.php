<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class ManagerAdvertController extends MshopController 
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
        $adverts = $this->model["advert"]->getAll();
        
        $this->data = [
          "adverts" =>$adverts,   
        ];
        
        $this->view = "manager/advert/index";
    }
    
    public function insert()
    {
        $validation = $this->injector["Validation"];
        
        $content = $validation->input("advert-content");
        
        $validation->validate($content, ["required","max_chars1024"], "Obsah reklamy");
        
        if($validation->isValidated() === true)
        {
            try {
                $this->model["advert"]->insert([
                    "content" => $content,
                ]);
                
                $this->injector["Logger"]->log("new advert created: '$content'", "SUCCESS:ADVERT_CREATE");
                $this->injector["LoraException"]->successMessage("Reklama přidána");
            } catch (Exception $ex) {
                
                $this->injector["Logger"]->log("new advert failed to create: '$content'", "FAILED:ADVERT_CREATE");
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
        }
        
        $this->redirect("mshop/manager/advert");
    }
    
    public function update()
    {
        $validation = $this->injector["Validation"];
        $ad_id = $this->u["param"];
        
        $content = $validation->input("advert-update-content");
        
        $validation->validate($content, ["required","max_chars1024"], "Obsah reklamy");
        
        if($validation->isValidated() === true)
        {
            try {
                $this->model["advert"]->update([
                    "content" => $content,
                ], $ad_id);
                
                $this->injector["Logger"]->log("advert ID:$ad_id updated: '$content'", "SUCCESS:ADVERT_UPDATE");
                $this->injector["LoraException"]->successMessage("Reklama upravena");
            } catch (Exception $ex) {
                 $this->injector["Logger"]->log("advert ID:$ad_id failed to update: '$content'. REASON-> ".$ex->getMessage(), "FAILED:ADVERT_UPDATE");
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
        }
        
        $this->redirect("mshop/manager/advert");
    }
    
    public function delete()
    {
        $validation = $this->injector["Validation"];
        $ad_id = intval($validation->input("id"));
        
        $validation->validate($ad_id, ["required", "int"], "ID Reklamy");
        
        if($validation->isValidated() === true)
        {
            try {
                $this->model["advert"]->delete($ad_id);
                
                 $this->injector["Logger"]->log("advert ID:$ad_id deleted", "SUCCESS:ADVERT_DELETE");
                $this->injector["LoraException"]->successMessage("Reklama smazána");
            } catch (Exception $ex) {
                 $this->injector["Logger"]->log("advert ID:$ad_id failed to delete. Reason-> ".$ex->getMessage(), "FAILED:ADVERT_UPDATE");
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
            }
        }
        $this->redirect("mshop/manager/advert");
    }
}

