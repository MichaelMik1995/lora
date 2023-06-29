<?php
declare (strict_types=1);

namespace App\Modules\DocumentationModule\Controller;

use App\Controller\Controller;
//Module Model
use App\Modules\DocumentationModule\Model\Documentation;   
use App\Core\Lib\FormValidator;
use App\Core\Application\Redirect;
use App\Core\Lib\Utils\StringUtils;
use App\Middleware\Auth;
use App\Exception\LoraException;

/**
 * 
 */
class DocumentationController extends Controller
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
     * @instance of main model: Documentation() of this controller.
     */
    protected $model;
    
    /**
     * @var string <p>Page title set</p>
     */
    public $title;
    
    protected $template_folder = "";
    
    
    /**
     * @var object <p>Instance of splitter</p>
     */
    protected $documentation_controll;

    
    public function __construct($injector)
    {
        parent::__construct($this->title, $injector);
        
        $this->injector = $injector;
    }
    
    /**
     * Can use for viewing all tables (rows) in template
     * @return string
     */
    public function index(Documentation $documentation) 
    {
        $get_all = $documentation->getAll();
                
        $this->data = [
            "categories" => $get_all,
        ];

        return $this->view = $this->template_folder."index";
    }

    /**
     * Can use for viewing one table (row) in template
     * @return void
     */
    public function show(Auth $auth, Documentation $documentation)
    {
        //header('Content-Type: application/json');
        $url = $this->u["url"];
        $get_one = $documentation->get($url);


        /* $this->data = [
            "get" => $get_one,
        ];
        
        return $this->view = $this->template_folder."show";*/
        echo json_encode([
            "content" => $get_one["_content"], 
            "title" => $get_one["title"],
            "version" => $get_one["version"],
            "category" => $get_one["category"],
            "created_at" => DATE("d.m.Y H:i:s", $get_one["created_at"]),
            "edit_access" => $auth->is_admin,
            ]);
    }

    /**
     * Can use for viewing form to create a new row
     * @return string
     */
    public function create(Documentation $documentation)
    {
        $get_versions = $documentation->getVersions();
        $get_categories = $documentation->getCategories();
        $this->data = [
            "form" => $this->injector["Easytext"]->form("content", "", ["hide_submit" => 1, "height" => "32em"]),
            "versions" => $get_versions,
            "categories" => $get_categories,
        ];
        return $this->view = $this->template_folder."create";
    }

    /**
     * Can use for validation data from create form and save
     * @return void
     */
    public function insert(Documentation $documentation, LoraException $lora_exception, StringUtils $string_utils)
    {
        //Fill $post variable with values of form fields
        $post = $this->input("title", "required,maxchars128", "Název")
                ->input("version", "maxchars128", "Vybraná verze")
                ->input("add-version", "maxchars128", "Nová verze")
                ->input("category", "maxchars128", "Vybraná kategorie")
                ->input("add-category", "maxchars128", "Kategorie")
                ->input("content", "required,maxchars6000")->returnFields();

        $url = $string_utils->toSlug($post["title"]);

        try {

            //returns true or THROW
            $this->validate();
            $documentation->insert($post, $url, $string_utils);
            $lora_exception->successMessage("List byl úspěšně přidán");
            @Redirect::redirect("documentation");
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for viewing form to edit row (getting data from url parameter)
     * @return string
     */
    public function edit(Documentation $documentation)
    {
        //$this->injector["Auth"]->access(["admin"]);

        $url = $this->u["url"];

        $get = $documentation->get($url);
        $get_versions = $documentation->getVersions();
        $get_categories = $documentation->getCategories();

        $this->data = [
            "documentation"=> $get,
            "form" => $this->injector["Easytext"]->form("content", $get["content"], ["hide_submit" => 1, "height" => "32em"]),
            "versions" => $get_versions,
            "categories" => $get_categories,
        ];
        return $this->view = $this->template_folder."edit";
    }

    /**
     * Can use for validation edited data and update row
     * @return void
     */
    public function update(Documentation $documentation, LoraException $lora_exception)
    {
        //$this->injector["Auth"]->access(["admin"]);

        $post = $this->input("title", "required,maxchars128", "Název")
                ->input("version", "maxchars128", "Vybraná verze")
                ->input("add-version", "maxchars128", "Nová verze")
                ->input("category", "maxchars128", "Vybraná kategorie")
                ->input("add-category", "maxchars128", "Kategorie")
                ->input("url", "required,maxchars128,url", "URL")
                ->input("content", "required,maxchars6000")->returnFields();

        try {
            $this->validate();
            $documentation->update($post, StringUtils::instance());
            $lora_exception->successMessage("Webová stránka upravena!");
            @Redirect::redirect("documentation");
            
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }

    /**
     * Can use for deleting row
     * @return void
     */
    public function delete(Documentation $documentation, LoraException $lora_exception)
    {

        try {
            //delete
            $documentation->delete();
            $lora_exception->successMessage("Příspěvek byl smazán!");
            @Redirect::redirect("documentation");
        }catch(LoraException $ex)
        {
            $lora_exception->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
    }
}

