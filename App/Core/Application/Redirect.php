<?php
declare(strict_types=1);

namespace App\Core\Application;

class Redirect
{
    private static $_instance;
    private static int $_instance_id;

    public function __construct(){}

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

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
    public function to(string $redirect_url = ""): Void
    {
        header("location: /".$redirect_url);
        exit();
    }

    public function previous()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}