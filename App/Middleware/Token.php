<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Middleware;

/**
 * Description of Token
 *
 * @author miroka
 */
class Token 
{
    public function __construct() 
    {
        //Generate session token
    }

    public function return(): Bool
    {
        return true;
    }

    public function error(): array
    {
        return [];
    }
}
