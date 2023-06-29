<?php
declare(strict_types = 1);

namespace Route\Middleware;

use App\Middleware\RestrictedIps;
use App\Middleware\FormToken;
use App\Middleware\Token;
use App\Middleware\Session;
use App\Middleware\LayerOne\RouteValidator;

trait MiddlewareGroup
{

    public static function return(): Array
    {
        return 
        [

            //For all Headers with DEFAULT request
            "default" => [

                //Banned,
                RestrictedIps::class,
                RouteValidator::class,
            ],

            "request" => [
                Token::class,
            ],
        
            //If empty($_POST[]) and url contains :
            "get" => [
                Token::class,
            ],
        
            ## IF !empty POST ##
            //
            "insert" => [
                FormToken::class,
                Session::class,
            ],
        
            "update" => [
                FormToken::class,
                Session::class,
            ],
        
            "delete" => [
                FormToken::class,
                Session::class,
            ],

            "mixed" => [
                FormToken::class,
                Session::class,
            ],
        ];
    }

}