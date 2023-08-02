<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace App\Core\Interface;

/**
 *
 * @author miroji
 */
interface LoggerInterface
{
    const 
        MESSAGE_INFO = 1,
        MESSAGE_WARNING = 2,
        MESSAGE_EXCEPTION = 3,
        MESSAGE_ERROR = 4;
 
    public function log(string $message, int $log_type);
    public function error();
    public function catchError();
}
