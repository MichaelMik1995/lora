<?php
declare(strict_types=1);
namespace App\Controller;

use App\Core\DI\DIContainer;
use App\Controller\Controller;
use App\Core\Lib\Utils\UrlUtils;

/**
 * Description of IndexController
 *
 * @author miroka
 */
class IndexController extends Controller
{
    public $template;
    public $u;
    
    public function __construct(DIContainer $container = null) 
    {
        parent::__construct($container);
    }
    
    public function index()
    {
        //Test if module has config ini with key CSS:
        $url = UrlUtils::urlParse($_SERVER["REQUEST_URI"]);
        $parse_to_module = $url["controller"];

        //check if config exists
        $config_file = "App/Modules/".ucfirst($parse_to_module)."Module/config/config.ini";
        if(file_exists($config_file))
        {
            $parse_config = parse_ini_file($config_file);
            $get_css = $parse_config["CSS"];

            $explode_css = explode(",", $get_css);
            $this_css = [str_replace("-","", $parse_to_module)];

            $css = array_merge($explode_css, $this_css);

        }
        else
        {
            $css[] = str_replace("-","", $parse_to_module);
        }

        $this->data = [
            "css" => $css,
        ];
        
        $this->view = "index";
    }
    
}
