<?php
declare(strict_types=1);

namespace App\Controller;
use App\Core\Application\Redirect;

class RouteController 
{
    use Redirect;

    public function getRoute(string $route, string $method, array $data = [])
    {
        echo "yes";
    }

    public function getUrl()
    {
        
        
        $route_encoded = $_POST["route"];
        
        
        //entry from javascript $.post only
        //
        //decode from base64
        
        //reparse to register route
        
        //find register route and return URL
    }
}