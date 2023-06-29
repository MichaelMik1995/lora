<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller;

use App\Controller\Controller;
//Module Model
 
use App\Modules\MshopModule\Controller\ShopController;

//Splitters SHOP
use App\Modules\MshopModule\Controller\Splitter\DisscussionController;
use App\Modules\MshopModule\Controller\Splitter\MshopProductController;
use App\Modules\MshopModule\Controller\Splitter\MshopOrderController;
use App\Modules\MshopModule\Controller\Splitter\MshopFinderController;
use App\Modules\MshopModule\Controller\Splitter\BasketController;
use App\Modules\MshopModule\Controller\Splitter\MshopReviewController;
use App\Modules\MshopModule\Controller\Splitter\MshopCustomerController;

//Splitters MANAGER
use App\Modules\MshopModule\Controller\Splitter\ManagerProductController;
use App\Modules\MshopModule\Controller\Splitter\ManagerCategoryController;
use App\Modules\MshopModule\Controller\Splitter\ManagerDashboardController;
use App\Modules\MshopModule\Controller\Splitter\ManagerOrderController;
use App\Modules\MshopModule\Controller\Splitter\ManagerLogController;
use App\Modules\MshopModule\Controller\Splitter\ManagerDisscussionController;
use App\Modules\MshopModule\Controller\Splitter\ManagerAdvertController;
use App\Modules\MshopModule\Controller\Splitter\ManagerInvoiceController;
use App\Modules\MshopModule\Controller\Splitter\ManagerStatisticController;
use App\Modules\MshopModule\Controller\Splitter\ManagerTransportController;
use App\Modules\MshopModule\Controller\Splitter\ManagerHelpController;


class MshopController extends Controller 
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
    
    /**
     * 
     * @var object <p>Instanced Splitter shop controller depends on URL</p>
     */
    protected $shop_controll;
    
    /**
     * 
     * @var object <p>Instanced Splitter manager controller depends on URL</p>
     */
    protected $manager_controll;
    
    /**
     * 
     * @var string <p>Main title of actual page</p>
     */
    protected $mshop_title;
    
    /**
     * 
     * @var array <p>Instanced models transmit to splitters</p>
     */
    private $model;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
        
        $this->model = [
            "product" => new \App\Modules\MshopModule\Model\product(),
            "basket" => new \App\Modules\MshopModule\Model\basket(),
            "category" => new \App\Modules\MshopModule\Model\Category(),
            "order" => new \App\Modules\MshopModule\Model\MshopOrder(),
            "disscussion" => new \App\Modules\MshopModule\Model\ProductDiscussion(),
            "logger" => new \App\Modules\MshopModule\Model\MshopLogger(),
            "log" => new \App\Modules\MshopModule\Model\MshopLog(),
            "review" => new \App\Modules\MshopModule\Model\MshopEvaluation(),
            "state" => new \App\Modules\MshopModule\Model\MshopState(),
            "ip" => $_SERVER["REMOTE_ADDR"],
            "branch" => new \App\Modules\MshopModule\Model\MshopBranches(),
            "advert" => new \App\Modules\MshopModule\Model\MshopAdvert(),
        ];
        
    }
    
    
    public function index() 
    {
        $this->redirect("mshop/shop/main");
    }
    
    /**
     * Required no special access -> for customers, members (/mshop/shop/:url/:param)
     */
    public function shop()
    {
        $page = $this->u["page"];
        
        
        //Shop pages
        $available_pages_shop = [
            "main" => "main",
        ];
        
        $this->splitter(ShopController::class, $available_pages_shop, "Hlavní");
        
        //Product pages
        $avaliable_pages_product = [
            "products" => "index",
            "product-show" => "show",
            
        ];
        
        $this->splitter(MshopProductController::class, $avaliable_pages_product);
        
        
        //Basket pages
        $basket_pages = [
            "basket"=>"basket",
            "add-basket" => "addBasket",
            "remove-product-from-basket" => "removeFromBasket",
            "recount-basket" => "recountBasket"
        ];
        
        $this->splitter(BasketController::class, $basket_pages);
        
        $this->splitter(MshopOrderController::class, [
            "order" => "order",
            "remove-order" => "removeOrder",
            "order-update" => "orderUpdate",
            "order-summary" => "orderSummary",
            "write-order" => "writeOrder",
        ]);
        
        //Basket pages
        $review_pages = [
            "review-insert"=>"insert",
        ];
        
        $this->splitter(MshopReviewController::class, $review_pages);
        
        $this->splitter(MshopFinderController::class, [
            "find" => "find",
        ]);
        
        $this->splitter(DisscussionController::class, [
            "discussion-insert" => "insert",
            "disscussion-add-comment" => "addComment"
        ]);
        
        if($this->injector["Auth"]->isLogged() == true)
        {
            $this->splitter(MshopCustomerController::class, [
                "customer" => "index",
            ]);
        }
        
        //mshop index_data
        $ip = $_SERVER["REMOTE_ADDR"];
            if(isset($_SESSION[$ip]))
            {
                $get_order = $this->model["basket"]->getOrder($_SESSION[$ip]["ORDER_ID"]);

                if(@$get_order["solved"] == 0)
                {
                    $count_orders = count($this->model["basket"]->getOrderProducts($_SESSION[$ip]["ORDER_ID"]));
                }
                else
                {
                    $count_orders = 0;
                }

            }
            else
            {
                $count_orders = 0;
            }
        
        $this->data = [
                "categories" => $this->model["category"]->getAll("category_name ASC"),  
                "orders" => $count_orders,
                
            ];
    }
    
    /**
     * required access ADMIN PROD-MAN for accessing page (/mshop/manager/:url/:param)
     */
    public function manager()
    {
        $this->injector["Auth"]->access(["admin", "prod-man"]);
       
        $this->splitter_manager(ManagerDashboardController::class, [
            "dashboard" => "dashboard",
        ]);
        
        $this->splitter_manager(ManagerOrderController::class, [
            "orders" => "index",
            "order-show" => "show",
            "order-find" => "orderFind",
            "order-change-status" => "changeStatus",
            "order-issue-products" => "orderIssue",
        ]);
        
        
        $this->splitter_manager(ManagerProductController::class, [
            "products" => "index", 
            "manager-product-show" => "show",
            "product-create" => "create",
            "product-insert" => "insert",
            "product-edit" => "edit",
            "product-update" => "update",
            "product-delete" => "delete",
            "product-image-delete" => "imageDelete",
            "product-add-images" => "addImages"
        ]);
        
        $this->splitter_manager(ManagerCategoryController::class, [
            "category" => "index",
            "category-insert" => "categoryInsert",
            "subcategory-insert" => "subcategoryInsert",
            "subcategory-delete" => "subcategoryDelete",
            "category-delete" => "categoryDelete"
            
        ]);
        
        $this->splitter_manager(ManagerLogController::class, [
            "log" => "index",
        ]);
        
        $this->splitter_manager(ManagerDisscussionController::class, [
            "product-discussion" => "index",
            "disscussion-add-comment" => "addComment"
        ]);
        
        $this->splitter_manager(ManagerAdvertController::class, [
            "advert" => "index",
            "advert-insert" => "insert",
            "advert-update" => "update",
            "advert-delete" => "delete",
        ]);
        
        $this->splitter_manager(ManagerInvoiceController::class, [
            "invoices" => "index",
            "invoice-template" => "templateShow",
            "invoice-show" => "show",
            "invoice-save" => "save"
        ]);
        
        $this->splitter_manager(ManagerStatisticController::class, [
            "statistic" => "index",
        ]);
        
        $this->splitter_manager(ManagerTransportController::class, [
            "transport" => "index",
        ]);

        $this->splitter_manager(ManagerHelpController::class, [
            "help" => "index",
        ]);
        
        
        $get_all = $this->model["disscussion"]->getForManager("for_company DESC");     
        $get_unsolved_orders = $this->model["order"]->getUnfinished();
        $get_unpublished_products = $this->model["product"]->getUnvalidatedProducts();
        
        $this->data = [
            "count_dissccussions" => count($get_all),
            "count_orders" => count($get_unsolved_orders),
            "count_unpublished_products" => count($get_unpublished_products),
        ];
    }
    
    
    private function splitter(string $class_name, array $pages_array, string $title="Shop")
    {
        $this->title = $title;
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            
            $method = $pages_array[$page];
            
            $this->shop_controll = new $class_name($this->injector, $this->model);
            $this->shop_controll->u = $this->u;
            $this->shop_controll->$method();
        }
    }
    
    private function splitter_manager(string $class_name, array $pages_array, string $title="Shop")
    {
        $this->title = $title;
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            
            $method = $pages_array[$page];
            
            $this->manager_controll = new $class_name($this->injector, $this->model);
            $this->manager_controll->u = $this->u;
            
            $this->manager_controll->$method();
        }
    }
    
}

