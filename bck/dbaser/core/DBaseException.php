<?php
declare(strict_types=1);

namespace Lora\DBaser\Core;

use Exception;

/**
 * Description of newPHPClass
 *
 * @author miroka
 */
class DBaseException extends Exception
{
    private array $error = [];
    
    public function __construct() 
    {
        
    }
    
    public function return()
    {
        
    }
}
