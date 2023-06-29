<?php
/*
    Plugin BMailor generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\BMailor;

use Lora\Compiler\Compiler;

class BMailor
{
    /**
     * 
     * @var type
     */
    public $is_smtp = false;
    
    /**
     * 
     * @var type
     */
    public $is_pop3 = false;
    
    /**
     * 
     * @var type
     */
    public $is_base_mail = true;
    
    
    public function __construct()
    {
        
    }
    
    public function send(string $mail_to, string $subject, string $message, array $headers = [])
    {
        return mail($mail_to, $subject, $message, $headers);
    }
}
