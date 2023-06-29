<?php
declare (strict_types=1);

namespace App\Modules\MshopModule\Controller\Splitter;

use App\Modules\MshopModule\Controller\MshopController;
//Module Model  


class MshopProductController extends MshopController 
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
        $route_param = $this->u["param"];
        $product = $this->model["product"];
        $category = $this->model["category"];
        
        if($route_param == "")
        {
            $get_products = $product->getRated(10);
            $header = "Nejlépe hodnocené produkty";

            $category_filter = false;
            $subcategory = "";
        }
        else
        {
            $explode_full_route_param = explode("&", $route_param);

            //For sorting
            $explode_route_param = explode("=", $explode_full_route_param[0]);
            $sort_action = $explode_route_param[0];
            $sort_param = $explode_route_param[1];

            if(count($explode_full_route_param) == 2)
            {
                //In category
                $explode_category_route_param = explode("=", $explode_full_route_param[1]);
                $route_param_key = $explode_category_route_param[0];
                $category_slug = $explode_category_route_param[1];

                $array_getSorted = $product->getSortedProducts($sort_action, $sort_param, $category_slug);
                $get_products = $array_getSorted[0];
                $header = $array_getSorted[1];

                $category_filter = true;
                $subcategory = $category_slug;
                $subcategory_name = $category->getSubcategoryRealName($subcategory);
            }
            else
            {
                if($sort_action == "filter-category")
                {
                    $get_products = $product->getProductsByCategory($sort_param);


                    $category_filter = true;
                    $subcategory = $sort_param;
                    $subcategory_name = $category->getSubcategoryRealName($subcategory);
                    $header = "Všechny produkty z kategorie: $subcategory_name";
                }  
                else
                {
                    //all products sorting
                    $array_getSorted = $product->getSortedProducts($sort_action, $sort_param);
                    $get_products = $array_getSorted[0];
                    $header = $array_getSorted[1];

                    $category_filter = false;
                    $subcategory = "";
                }

            }
        }
        
        //Homepage of random products & category menu
                $this->data = [
                  "products" => $get_products,
                    "header" => $header,
                    "number_utils" => $this->injector["NumberUtils"],
                    "category_filter" => $category_filter,
                    "subcategory" => $subcategory,
                    "subcategory_name" => @$subcategory_name,
                    "ip" => $_SERVER["REMOTE_ADDR"],
                ];
                
                $this->view = "shop/products/index";
    }
    
    public function show() 
    {
        
        $route_param = $this->u["param"];
        $get_one = $this->model["product"]->getProduct($route_param); //Getting one row from table
        $this->title = "Manager";
        $refreshed_page = $this->injector["UrlUtils"]->is_page_refreshed();

        if(!$refreshed_page)
        {
            $this->model["product"]->productVisited($route_param);
        }

        $this->data = [
            "product" => $get_one,
            "auth" => $this->injector["Auth"]->isAuth(["admin", "editor"]),
            "easy_text" => $this->injector["Easytext"],
            "number_utils" => $this->injector["NumberUtils"],
            "user_uid" => @$this->injector["Auth"]->user_uid,
            "ip" => $_SERVER["REMOTE_ADDR"],
        ];

        $this->view = "shop/products/show";
    }
}

