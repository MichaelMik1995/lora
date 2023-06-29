<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;

use App\Modules\MshopModule\Model\MshopEmail;
//Module Model  


class ManagerDashboardController extends MshopController 
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
    protected $mail;
    
    public function __construct($injector, $model)
    {
        parent::__construct($injector, $this->message);
        
        $this->module = "Mshop";
        $this->injector = $injector;
        $this->model = $model;
        $this->mail = new MshopEmail();
    }
    
    
    public function dashboard() 
    {
        
        $get_suma_earns = $this->model["product"]->getEarns();
        $best_product_eval = $this->model["product"]->getRated(1);
        $best_view = $this->model["product"]->getSortedLimit("visited DESC", 1);
        $best_buyed = $this->model["product"]->getSortedLimit("buyed DESC", 1);
        
        $this->data = [
            "earning" => @$this->injector["NumberUtils"]->parseNumber($get_suma_earns),
            "best_product_eval" => @$best_product_eval[0],
            "best_view" => @$best_view[0],
            "best_buyed" => @$best_buyed[0],
        ];
        
        //$this->mail->testEmail();
        $this->view = "manager/dashboard/index"; 
    }
}

