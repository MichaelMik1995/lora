<?php
declare (strict_types=1);

namespace App\Modules\GamesModule\Controller\Splitter;

use App\Core\Application\Redirect;
use App\Exception\LoraException;
use App\Middleware\FormValidator;
use App\Modules\GamesModule\Controller\GamesController;
//Module Model  


class GamesCrudController extends GamesController 
{
    use FormValidator;
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
     * @instance of main model: Shop() of this controller.
     */
    public $model;
    
    public $title = "";

    
    public function __construct($injector, $model = null)
    {
        parent::__construct($injector);
        
        $this->module = "Games";
        $this->injector = $injector;
        $this->model = $model;
    }
    
    
    public function index() 
    {
      
    }

    public function create()
    {
        $this->data = [
            "genres" => $this->model["game-genres"]?->getAll(),
            "form" => $this->injector["Easytext"]->form("description", "", ["hide_submit"=>1]),
        ];

        return $this->view = "game/create";
    }

    public function insert()
    {
        $validation = $this->injector["Validation"];

        $title = $validation->input("title");
        $slug = $this->injector["StringUtils"]->toSlug($title);
        $genres = $validation->input("genres");

        $tags = $validation->input("tags");
        $description = $validation->input("description");

        $validation->validate($title, ["required", "max_chars128"], "Název hry");
        $validation->validate($genres, ["max_chars256"], "Žánry");
        $validation->validate($tags, ["max_chars256", "Tagy"]);
        $validation->validate($description, ["max_chars4096"], "Popis hry");

        if($validation->isValidated() === true)
        {

            try {
                //mk dir for source
                $source_dir = "./App/Modules/GamesModule/resources/games/$slug";
                if (!is_dir($source_dir)) {
                    mkdir($source_dir);
                    mkdir($source_dir . "/img");
                    mkdir($source_dir . "/img/thumb");
                    mkdir($source_dir . "/src");
                }

                //insert to db
                $this->model["games"]->insert([
                    "name" => $title,
                    "url" => $slug,
                    "genre_slug" => $genres,
                    "tags" => $tags,
                    "description" => $description,
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);

                @Redirect::redirect("games/app/game-show/$slug");
            }catch(LoraException $ex)
            {
                $this->injector["LoraException"]->errorMessage($ex->getMessage());
                @Redirect::redirect("games/app/game-create");
            }


            //upload image

            //unzip && upload source
        }
    }  

    public function show()
    {
        $this->model["games"]->route_param = $this->u["param"];

        $get_game = $this->model["games"]->get();

        $this->data = [
            "game" => $get_game,
        ];
        return $this->view = "game/show";
    }
}

