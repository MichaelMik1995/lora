<?php

use App\Modules\ForumModule\Controller\ForumController;
use App\Modules\ForumModule\Controller\Splitter\ForumThemeController;
use App\Modules\ForumModule\Controller\Splitter\ForumThemeCategoryController;
use App\Modules\ForumModule\Controller\Splitter\ForumPostController;
use App\Modules\ForumModule\Controller\Splitter\ForumPostCommentController;
/**
 * Description of ForumRegister
 *
 * @author miroka
 */
class ForumRegister 
{
   public function register()
   {
        $class = ForumController::class;
        $theme_controller = ForumThemeController::class;
        $theme_category = ForumThemeCategoryController::class;
        $theme_post = ForumPostController::class;
        $post_comment = ForumPostCommentController::class;

        return [
            [
                "url" => "forum",
                "controller" => $class,
                "template" => "index",
                "route" => "forum.index@default",
                "classes" => [],
                "access" => "any"
            ],

            //Theme
            [
                "url" => "forum/theme/create",
                "controller" => $theme_controller,
                "template" => "theme/create",
                "route" => "forum.create@default",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            [
                "url" => "forum/theme/insert",
                "controller" => $theme_controller,
                "template" => "",
                "route" => "forum.insert@insert",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            [
                "url" => "forum/theme/show/:theme",
                "controller" => $theme_controller,
                "template" => "theme/index",
                "route" => "forum.index@get",
                "classes" => [],
                "access" => "any"
            ],
            [
                "url" => "forum/theme-edit/:theme",
                "controller" => $theme_controller,
                "template" => "theme/edit",
                "route" => "forum.edit@get",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            [
                "url" => "forum/theme-update",
                "controller" => $theme_controller,
                "template" => "",
                "route" => "forum.update@update",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            [
                "url" => "forum/theme-delete/:theme",
                "controller" => $theme_controller,
                "template" => "",
                "route" => "forum.delete@delete",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],

            //Category
            [
                "url" => "forum/category/create/:theme",
                "controller" => $theme_category,
                "template" => "category/create",
                "route" => "forum.create@get",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            
            [
                "url" => "forum/category/insert",
                "controller" => $theme_category,
                "template" => "",
                "route" => "forum.insert@insert",
                "classes" => [],
                "access" => "admin,editor,developer"
            ],
            //Post
            [
                "url" => "forum/posts/category/:category",
                "controller" => $theme_post,
                "template" => "post/index",
                "route" => "forum.index@get",
                "classes" => [],
                "access" => "any"
            ],
            [
                "url" => "forum/post-show/:url",
                "controller" => $theme_post,
                "template" => "post/show",
                "route" => "forum.show@get",
                "classes" => [],
                "access" => "any"
            ],
            [
                "url" => "forum/post-edit/:url",
                "controller" => $theme_post,
                "template" => "post/edit",
                "route" => "forum.edit@get",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/post-update",
                "controller" => $theme_post,
                "template" => "",
                "route" => "forum.update@update",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/post-delete/:url",
                "controller" => $theme_post,
                "template" => "",
                "route" => "forum.delete@get",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/post-close/:url",
                "controller" => $theme_post,
                "template" => "",
                "route" => "forum.close@get",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/post-open/:url",
                "controller" => $theme_post,
                "template" => "",
                "route" => "forum.open@get",
                "classes" => [],
                "access" => "admin,developer,editor"
            ],
            [
                "url" => "forum/post/create/:category",
                "controller" => $theme_post,
                "template" => "post/create",
                "route" => "forum.create@get",
                "classes" => [],
                "access" => "logged"
            ],
            
            [
                "url" => "forum/post/insert",
                "controller" => $theme_post,
                "template" => "",
                "route" => "forum.insert@insert",
                "classes" => [],
                "access" => "logged"
            ],

            //Post Comment
            [
                "url" => "forum/comment-insert",
                "controller" => $post_comment,
                "template" => "",
                "route" => "forum.insert@insert",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/comment-update",
                "controller" => $post_comment,
                "template" => "",
                "route" => "forum.update@update",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/comment-delete/:url",
                "controller" => $post_comment,
                "template" => "",
                "route" => "forum.delete@delete",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/comment-great/:url",
                "controller" => $post_comment,
                "template" => "",
                "route" => "forum.greatComment@get",
                "classes" => [],
                "access" => "logged"
            ],
            [
                "url" => "forum/comment-bad/:url",
                "controller" => $post_comment,
                "template" => "",
                "route" => "forum.badComment@get",
                "classes" => [],
                "access" => "logged"
            ],

            //Post Operation
        ];
   }
}

