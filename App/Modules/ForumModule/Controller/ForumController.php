<?php
declare (strict_types=1);

namespace App\Modules\ForumModule\Controller;

use App\Controller\Controller;

//Module Model
use App\Modules\ForumModule\Model\Forum;   
use App\Modules\ForumModule\Model\ForumTheme; 
use App\Modules\ForumModule\Model\ForumStyle;
use App\Modules\ForumModule\Model\ForumThemeCategory;
use App\Modules\ForumModule\Model\ForumPost;
use App\Modules\ForumModule\Model\ForumComment;


class ForumController extends Controller 
{
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Forum() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $forum_controll;

    protected $forum_style;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;

        $this->model["forum"] = new Forum();
        
        $this->model["style"] = new ForumStyle();
        $this->model["category"] = new ForumThemeCategory();
        $this->model["theme"] = new ForumTheme($this->model["category"]);
        $this->model["comment"] = new ForumComment();
        $this->model["post"] = new ForumPost($this->model["comment"]);

        $this->forum_style = $this->model["style"]->getForumStyle($this->injector["Config"]->var("FORUM_THEME"));


        /*$this->model = [
            "forum" => ,
            "theme" => new ForumTheme(),
            "style" => new ForumStyle(),
            "category" => new ForumThemeCategory(),
            "comment" => new ForumComment(),
            "post" => new ForumPost($this->model["comment"]),
            
        ];*/
    }
    
    
    public function index() 
    {
        $this->title = "Přehled";
        $themes = $this->model["theme"]->getAllForumTheme();

        $this->data = [
            "themes" => $themes,
            "style" => $this->model["style"]->getForumStyle($this->injector["Config"]->var("FORUM_THEME")),
        ];
    }
}

