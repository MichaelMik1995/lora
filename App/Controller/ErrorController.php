<?php

namespace App\Controller;

class ErrorController extends Controller
{

    public function __construct()
    {

    }
	public function index()
	{
            $this->data = [
                "error_message_header" => "OOPS!",
                "error_message" => 
                    "Vámi požadovaná stránka nebyla nalezena nebo nemáte oprávnění jí prohlížet!"
                . "<br> Zkuste se přihlásit a navštívit tuto stránku znovu",
                ];
	}

    public function middleware()
    {
        $this->data = [
            "messages" => array_unique($_SESSION["error_middleware"]),
                
            ];
    }

    public function badMethod()
    {
        $this->data = [
            "excepted_request" => $_SESSION["expected_request"],
        ];

        unset($_SESSION["expected_request"]);
    }

    public function badFunction()
    {
        
    }

    public function urlNotRegistered()
    {
        
    }

    function __destruct()
    {
        if(isset($_SESSION["error_middleware"]))
        {
            unset($_SESSION["error_middleware"]);
        }
    }
}
