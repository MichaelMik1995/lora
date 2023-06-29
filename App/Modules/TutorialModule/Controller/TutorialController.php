<?php
declare (strict_types=1);

namespace App\Modules\TutorialModule\Controller;

use App\Controller\Controller;
use App\Core\Application\Redirect;

//Module Model
use App\Modules\TutorialModule\Model\Tutorial;
use Exception;

class TutorialController extends Controller 
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
     * @instance of main model: Tutorial() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $tutorial_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;

        $this->model = [
            "tutorial" => new Tutorial()
        ];
    }
    
    
    public function index() 
    {
        $get_all = $this->model["tutorial"]->getAll();

        $this->data = [
            "tutorials" => $get_all,
        ];
    }

    public function show()
    {
        $this->data = [
            "tutorial" => $this->model["tutorial"]?->get(),
        ];
    }

    public function create()
    {
        $this->injector["Auth"]->access(["admin"]);
        $tags = $this->model["tutorial"]->getTags();
        $this->data = [
            "tags" => $tags,
            "form" => $this->injector["Easytext"]->form("content", "", ["submit_text"=>"<i class='fa fa-plus-circle'></i> Vytvořit", "max_chars" => 9999]),
        ];
    }

    public function insert()
    {
        $this->injector["Auth"]->access(["admin"]);
        $validation = $this->injector["Validation"];

        $title = $validation->input("title");
        $tags = $validation->input("tags");
        $tags = str_replace(" ", "", $tags);
        $url = $this->injector["StringUtils"]->toSlug($title);
        $content = $validation->input("content");
        $short_content = $validation->input("short-content");

        $validation->validate($title, ["required","max_chars512"], "Název");
        $validation->validate($tags, ["max_chars4096"], "Tagy");
        $validation->validate($content, ["required","max_chars9999"], "Název");
        $validation->validate($short_content, ["required","max_chars512"], "Krátký popis");

        if($validation->isValidated() === true)
        {
            try {
                $this->model["tutorial"]->insert([
                    "title" => $title,
                    "url" => $url,
                    "author" => $this->injector["Auth"]->user_uid,
                    "content" => $content,
                    "short_content" => $short_content,
                    "tags" => $tags,
                    "created_at" => time(),
                    "updated_at" => time(),
                ]);

                $this->injector["LoraException"]->successMessage("Návod byl přidán");
            }catch(Exception $ex)
            {
                $this->injector["LoraException"]->errorMessage($ex->getMessage()); 
            }

            @Redirect::redirect("tutorial");
        }
    }

    public function edit()
    {
        $this->injector["Auth"]->access(["admin"]);
        $get = $this->model["tutorial"]?->get();
        $tags = $this->model["tutorial"]->getTags();

        $this->data = [
            "tutorial" => $get,
            "tags" => $tags,
            "form" => $this->injector["Easytext"]->form("content", $get['content'], ["submit_text"=>"<i class='fa fa-edit'></i> Upravit", "max_chars" => 9999]),
        ];
    }

    public function update()
    {

        $this->injector["Auth"]->access(["admin"]);
        $validation = $this->injector["Validation"];

        $title = $validation->input("title");
        $tags = $validation->input("tags");
        $url = $validation->input("url");
        $tags = str_replace(" ", "", $tags);
        $content = $validation->input("content");
        $short_content = $validation->input("short-content");

        $validation->validate($title, ["required","max_chars512"], "Název");
        $validation->validate($tags, ["max_chars4096"], "Tagy");
        $validation->validate($url, ["required","max_chars4096"], "ID příspěvku");
        $validation->validate($content, ["required","max_chars9999"], "Název");
        $validation->validate($short_content, ["required","max_chars512"], "Krátký popis");

        if($validation->isValidated() === true)
        {
            try {
                $this->model["tutorial"]->update([
                    "title" => $title,
                    "content" => $content,
                    "short_content" => $short_content,
                    "tags" => $tags,
                    "updated_at" => time(),
                ]);

                $this->injector["LoraException"]->successMessage("Návod byl upraven");
                @Redirect::redirect("tutorial/show/".$url);
            }catch(Exception $ex)
            {
                $this->injector["LoraException"]->errorMessage($ex->getMessage()); 
                @Redirect::redirect("tutorial/edit/".$url);
            }

            
        }
    }

    public function delete()
    {
        $this->injector["Auth"]->access(["admin"]);
        try {
            $this->model["tutorial"]->delete();
            
            $this->injector["LoraException"]->successMessage("Příspěvek byl smazán");
        }catch(Exception $ex)
        {
            $this->injector["LoraException"]->errorMessage($ex->getMessage()); 
        }
        @Redirect::redirect("tutorial");
    }
    
    private function splitter(string $class_name, array $pages_array, string $title="Shop")
    {
        $this->title = $title;
        $page = $this->u["page"];
        if(array_key_exists($page, $pages_array))
        {
            $method = $pages_array[$page];
            
            $this->tutorial_controll = new $class_name($this->injector, $this->model);
            $this->tutorial_controll->u = $this->u;
            $this->tutorial_controll->$method();
        }
    }
}

