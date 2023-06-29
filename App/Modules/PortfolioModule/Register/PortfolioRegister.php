<?php

use App\Modules\PortfolioModule\Controller\PortfolioController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioDasboardController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioItemController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioReviewController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioTypeController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioCategoryController;
use App\Modules\PortfolioModule\Controller\Splitter\PortfolioCommentController;
/*
 * Description of PortfolioRegister
 *
 * @author miroka
 */
class PortfolioRegister 
{
   public function register()
   {
        $class = PortfolioController::class;
        $class_dasboard = PortfolioDasboardController::class;
        $class_item = PortfolioItemController::class;
        $class_type = PortfolioTypeController::class;
        $class_category = PortfolioCategoryController::class;
        $class_comment = PortfolioCommentController::class;
        $class_review = PortfolioReviewController::class;

        return [
            [
                "url" => "portfolio",
                "controller" => $class_dasboard,
                "template" => "dashboard/index",
                "route" => "portfolio.index@default",
                "classes" => [],
            ],
            [
                "url" => "portfolio/types/:page",
                "controller" => $class_dasboard,
                "template" => "types/index",
                "route" => "portfolio.showTypes@get",
                "classes" => [],
            ],

            [
                "url" => "portfolio/type-edit/:param",
                "controller" => $class_type,
                "template" => "item/edit",
                "route" => "portfolio.edit@get",
                "classes" => [],
            ],

            [
                "url" => "portfolio/type-delete/:param",
                "controller" => $class_type,
                "template" => "",
                "route" => "portfolio.delete@delete",
                "classes" => [],
            ],

            [
                "url" => "portfolio/type-update",
                "controller" => $class_type,
                "template" => "",
                "route" => "portfolio.update@update",
                "classes" => [],
            ],

            //Item
            [
                "url" => "portfolio/item/:url",
                "controller" => $class_item,
                "template" => "item/show",
                "route" => "portfolio.show@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/item-edit/:url",
                "controller" => $class_item,
                "template" => "item/edit",
                "route" => "portfolio.edit@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/item-update/:url",
                "controller" => $class_item,
                "template" => "",
                "route" => "portfolio.update@update",
                "classes" => [],
            ],
            [
                "url" => "portfolio/item-delete",
                "controller" => $class_item,
                "template" => "",
                "route" => "portfolio.delete@delete",
                "classes" => [],
            ],
            [
                "url" => "portfolio/item-remove-image",
                "controller" => $class_item,
                "template" => "",
                "route" => "portfolio.deleteItemImage@delete",
                "classes" => [],
            ],
            [
                "url" => "portfolio/create-item/:category",
                "controller" => $class_item,
                "template" => "item/create",
                "route" => "portfolio.create@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/insert-item",
                "controller" => $class_item,
                "template" => "",
                "route" => "portfolio.insert@insert",
                "classes" => [],
            ],

            //Types
            [
                "url" => "portfolio/type-create",
                "controller" => $class_type,
                "template" => "types/create",
                "route" => "portfolio.create@default",
                "classes" => [],
            ],
            [
                "url" => "portfolio/type-insert",
                "controller" => $class_type,
                "template" => "types/insert",
                "route" => "portfolio.insert@insert",
                "classes" => [],
            ],

            //Categories
            [   
                "url" => "portfolio/category/:page",
                "controller" => $class_item,
                "template" => "item/index",
                "route" => "portfolio.index@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/category-create/:page",
                "controller" => $class_category,
                "template" => "category/create",
                "route" => "portfolio.create@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/category-edit/:type/:category",
                "controller" => $class_category,
                "template" => "category/edit",
                "route" => "portfolio.edit@get",
                "classes" => [],
            ],
            [
                "url" => "portfolio/category-insert",
                "controller" => $class_category,
                "template" => "",
                "route" => "portfolio.insert@insert",
                "classes" => [],
            ],
            
            [
                "url" => "portfolio/category-update",
                "controller" => $class_category,
                "template" => "",
                "route" => "portfolio.update@update",
                "classes" => [],
            ],
            
            [
                "url" => "portfolio/category-delete",
                "controller" => $class_category,
                "template" => "",
                "route" => "portfolio.delete@delete",
                "classes" => [],
            ],

            //Comments
            [
                "url" => "portfolio/item-comment-insert",
                "controller" => $class_comment,
                "template" => "",
                "route" => "portfolio.insert@insert",
                "classes" => [],
            ],
            [
                "url" => "portfolio/item-answer-insert",
                "controller" => $class_comment,
                "template" => "",
                "route" => "portfolio.insertAnswer@insert",
                "classes" => [],
            ],

            //Reviews
            [
                "url" => "portfolio/item-review-insert",
                "controller" => $class_review,
                "template" => "",
                "route" => "portfolio.insert@insert",
                "classes" => [],
            ],
        ];
   }
}

