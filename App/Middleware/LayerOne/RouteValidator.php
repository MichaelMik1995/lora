<?php
declare(strict_types=1);

namespace App\Middleware\LayerOne;

class RouteValidator
{

    protected $request_url;
    protected bool $response = false;

    public function __construct()
    {
        $this->request_url = $_SERVER["REQUEST_URI"];
        $this->checkRequestAddress();
    }

    public function return(): Bool
    {
        return $this->response;
    }

    public function error(): Array
    {
        return [];
    }

    private function checkRequestAddress()
    {

        if(preg_match( '|(/[^/]+)(/[^/]+/?)?|', $this->request_url))
        {
            $this->response = true;
        }
        else
        {
            $this->response = false;
        }
    }


}