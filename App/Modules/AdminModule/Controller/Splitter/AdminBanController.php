<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

use App\Modules\AdminModule\Controller\AdminController;
//Module Model  

use App\Modules\AdminModule\Model\AdminBan;


class AdminBanController extends AdminController 
{
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;

    protected $template_folder = "bannedips/";

    
    public function __construct($container, $model)
    {
        parent::__construct($container);
        
        $this->module = "admin";
        $this->container = $container;
        $this->model = $model;
    }
    
    
    public function index(AdminBan $ban) 
    {
        $patterns = $ban->pattern;
        print_r($patterns);
    }
}

