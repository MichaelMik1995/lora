<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Middleware;

/**
 * Description of Headers
 *
 * @author miroka
 */
class Headers 
{
    protected $web_address;
    
    public function __construct($web_address) 
    {
        $this->web_address = $web_address;
    }
    
    public function return()
    {
        header("Access-Control-Allow-Headers: Authorization");
        header("Access-Control-Allow-Origin: ".$this->web_address);
        return true;

    }
    
    private function headerConstruct()
    {
        
    }
}
