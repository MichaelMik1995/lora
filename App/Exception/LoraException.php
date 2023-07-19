<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Exception;

/**
 * Description of LoraException
 *
 * @author michaelmik
 */
class LoraException extends \Exception
{
    
    private static $_instance;
    public static int $_instance_id;

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
     /**
     * 
     * @param string $message -> add message to catch exeption ErrorUser
     */
    public function errorMessage($message) {
        if (isset($_SESSION['message'])) {
            $_SESSION['message'][] = $message;
        } else {
            $_SESSION['message'] = array($message);
        }
    }
    
     public function successMessage($message) {
        if (isset($_SESSION['message_true'])) {
            $_SESSION['message_true'][] = $message;
        } else {
            $_SESSION['message_true'] = array($message);
        }
    }
    
    public function returnMessage() {
        if (isset($_SESSION['message'])) {
            $mess = $_SESSION['message'];
            unset($_SESSION['message']);
            return $mess;
        } else {
            return array();
        }
    }
    
    public function returnMessageTrue() {
        if (isset($_SESSION['message_true'])) {
            $mess = $_SESSION['message_true'];
            unset($_SESSION['message_true']);
            return $mess;
        } else {
            return array();
        }
    }
}
