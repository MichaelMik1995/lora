<?php
declare (strict_types=1);

namespace App\Controller;

use App\Controller\Controller;

class RedirectController extends Controller 
{
    
    public $u;
    
    public function index() 
    {
        $page = $this->u["page"];
        $request = $this->u["request"];

        $parse_page = str_replace("_", "/", $page);

        $this->redirect($parse_page);
    }
}
?>
