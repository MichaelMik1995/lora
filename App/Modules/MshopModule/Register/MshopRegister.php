<?php

use App\Modules\MshopModule\Controller\MshopController;
use App\Modules\MshopModule\Controller\ManagerController;
/**
 * Description of ShopRegister
 *
 * @author miroka
 */
class MshopRegister 
{
   public function register()
   {
       $index = MshopController::class;
       $manager = ManagerController::class;
       return [
            [
                "url" => "mshop",
                "controller" => $index,
                "method" => "index",
                "template" => "index",
                "request" => "default",
                "module" => true,
            ],
           ["url"=>"mshop/shop/:page", "controller"=>$index, "method"=>"shop", "template"=>"shop_index", "request"=>"get"],
           ["url"=>"mshop/shop/:page/:param", "controller"=>$index, "method"=>"shop", "template"=>"shop_index", "request"=>"get"],
           //Manager
           ["url"=>"mshop/manager", "controller"=>$manager, "method"=>"index", "template"=>""],
           ["url"=>"mshop/manager/:page", "controller"=>$index, "method"=>"manager", "template"=>"manager_index", "request"=>"get"],
           ["url"=>"mshop/manager/:page/:param", "controller"=>$index, "method"=>"manager", "template"=>"manager_index", "request"=>"get"],
       ];
   }
}

