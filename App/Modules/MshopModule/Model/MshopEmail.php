<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;
use App\Core\Lib\EmailSender;

/**
 * Description of MshopEmail module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopEmail extends Mshop 
{
    private $sender;
    
    function __construct() {
        parent::__construct();
        $this->sender = new EmailSender();
        
        $this->sender->template_path = "App/Modules/MshopModule/resources/templates/email";
        $this->sender->template_extension = "template";
        
    }
    
    public function testEmail(string $template = "testemail")
    {
        $this->sender->send("shoesby@seznam.cz", "testo", $template);
    }
}
