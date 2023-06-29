<?php
declare (strict_types=1);

use App\Core\Module\SplitterRegistry;
use App\Core\View\Template;
use App\Middleware\Auth;
use App\Middleware\Validation;
//Module Model
use App\Modules\AboutModule\Model\About;    


class AboutController extends Controller 
{
    protected $injector;

    public function __construct($injector)
    {
        $this->injector = $injector;
    }
    
    public function index($url) 
    {
        //it is a module: about
        $this->module = "about";
        
        $about = new About();
        $action = @$url[1];
        $route_param = @$url[2];
        
        $splitter = new SplitterRegistry($this->module, $url, $this->injector);
        $this->data = $splitter->getSplittersData();
        $this->view = $splitter->getSplittersView();
        
        $array_utils = $this->injector["ArrayUtils"];  
        $injector = $array_utils->setLowerCaseVars($this->injector);
        
        extract($injector);
        
        switch($action)
        {
            default: $this->redirect("error"); break;
            
            case "":
                $this->header["title"] = "About";        //set dynamic web title
                $this->data = [];
                
                
                $this->view = "index"; 
                break;
        }
        
    }
}
?>

