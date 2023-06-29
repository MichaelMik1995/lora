<?php
declare(strict_types=1);

namespace App\Core\Application;
use Route\Middleware\MiddlewareGroup;

trait Redirect
{

    public static function route(string $url, array $data)
    {
        //url route type

        //data [page => "hello"]
    }

    /**
     * Redirecting to requesting url adress
     * 
     * @var string $redirect_url <p>url to redirect (ex.: controller/action/param)</p>
     */
    public static function redirect(string $redirect_url): Void
    {
        header("location: /".$redirect_url);
        exit();
    }

    public static function previous()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}