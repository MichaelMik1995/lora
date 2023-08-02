<?php
declare(strict_types=1);

namespace App\Core\Log;
use App\Core\Interface\LoggerInterface;

/**
 * Description of Logger
 *
 * @author ctyrka
 */
class RuntimeLogger implements LoggerInterface
{
    private static $_instance;
    private static int|null $_instance_id = null;
    private array $errors = [];
    
    public function instance()
    {
        if(self::$_instance == null && self::$_instance_id == null)
        {
            self::$_instance = new self;
            self::$_instance_id = rand(000000,999999);
        }
        
        return self::$_instance;
    }
    
    public function log($message, $log_type)
    {
        
    }
    
    public function error(int $error_type = 0): Array
    {
        return $this->errors[$error_type];
    }
    
    private function catchError() 
    {
        
    }
}
