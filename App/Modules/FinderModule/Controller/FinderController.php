<?php
declare (strict_types=1);

use App\Core\Module\SplitterRegistry;
use App\Core\View\Template;
use App\Middleware\Auth;
use App\Middleware\Validation;
//Module Model
use App\Modules\FinderModule\Model\Finder;    


class FinderController extends Controller 
{
    protected $injector;

    public function __construct($injector)
    {
        $this->injector = $injector;
    }
    
    public function index($url) 
    {
        //it is a module: finder
        $this->module = "finder";
        
        $finder = new Finder();
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
            
            case "find":
                $content = $validation->input["content"];
                
                $this->header["title"] = "Finder";        //set dynamic web title
                
                
                $this->data = [
                    "content" => $content,
                ];
                
                
                $this->view = "index"; 
                break;
        }
        
    }
}
?>

