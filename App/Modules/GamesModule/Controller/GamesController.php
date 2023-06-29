<?php
declare (strict_types=1);

namespace App\Modules\GamesModule\Controller;

use App\Controller\Controller;
use App\Core\Application\Redirect;
//Module Model
use App\Modules\GamesModule\Model\Games;    
use App\Modules\GamesModule\Controller\Splitter\GamesHomeDashboardController;
use App\Modules\GamesModule\Controller\Splitter\GamesCrudController;
use App\Modules\GamesModule\Controller\Splitter\GamesBoardController;
use App\Modules\GamesModule\Controller\Splitter\GamesTagsController;

use App\Modules\GamesModule\Model\GamesGenres;


class GamesController extends Controller 
{
    use Redirect;
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $injector;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Games() of this controller.
     */
    public $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $games_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;

        $this->model = [
            "games" => new Games(),
            "game-genres" => new GamesGenres(),
        ];
    }
    
    
    public function index() 
    { 
        //Index of
        if(!isset($this->u["page"]))
        {
            @Redirect::redirect("games/app/dashboard");
        }
    }

    public function app()
    {
        if(isset($this->u["page"]))
        {
            $page = $this->u["page"];
            $dashboard_pages = [
                "dashboard" => "dashboard",
            ];

            $games_crud = [
                "game-create" => "create",
                "game-insert" => "insert",
                "game-edit" => "edit",
                "game-show" => "show",
                "game-update" => "update",
                "game-delete" => "delete"
            ];

            $game_genres = [
                "board" => "index",
            ];

            $game_tags = [
                "games-by-tag" => "show",
            ];

            $this->splitter(GamesHomeDashboardController::class, $dashboard_pages, "Hlavní");
            $this->splitter(GamesCrudController::class, $games_crud, "Herna");
            $this->splitter(GamesBoardController::class, $game_genres, "Vybrané hry");
            $this->splitter(GamesTagsController::class, $game_tags, "Herní tagy");

            
            $this->data = [
                "genres" => $this->model["game-genres"]?->getAll(),
            ];
        }
        else
        {
            @Redirect::redirect("games/app/dashboard");
        }
    }

    public function visor()
    {

    }
    
    private function splitter(string $class_name, array $pages_array, string $title="Shop")
    {
        $this->title = $title;
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            $method = $pages_array[$page];
            
            $this->games_controll = new $class_name($this->injector, $this->model);
            $this->games_controll->u = $this->u;
            $this->games_controll->$method();
        }
    }
}

