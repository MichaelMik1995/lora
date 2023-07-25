<?php
declare (strict_types=1);

namespace App\Modules\UserModule\Controller\Splitter;

//Main module Controller
use App\Modules\UserModule\Controller\UserController;

//Core
use App\Middleware\Auth;
use App\Core\Application\Redirect;
use App\Core\DI\DIContainer;
use App\Exception\LoraException;
use App\Core\Lib\FormValidator;
use App\Modules\UserModule\Model\UserAnnouncement;

use App\Modules\UserModule\Model\UserData;


//Utils
use App\Core\Lib\Utils\StringUtils;
use Lora\Easytext\Easytext;

/**
 *  Main controller for module {Model_name}
 *
 * @author miroji <miroslav.jirgl@seznam.cz>
 * @version 3.2
 * @package lora/sandbox
 */
class UserDashboardController extends UserController 
{
    use FormValidator;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;

    /**
     * Template folder
     * @var string $template_folder
     */
    private string $template_folder = "dashboard/";

    /**
     * Splitter Title
     *
     * @var string
     */
    protected string $splitter_title = "";

    
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
        
        $this->module = "User";
    }
    
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return string
     */
    public function dashboard(UserData $user, UserAnnouncement $announcement) 
    {
        
        $last_annoucenment = $announcement->getLastAnnouncement();
        
        $this->data = [
            "announcement" => $last_annoucenment,
        ]; 

        return $this->view = $this->template_folder."index";
    }

}

