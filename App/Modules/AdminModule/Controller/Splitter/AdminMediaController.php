<?php
declare (strict_types=1);

namespace App\Modules\AdminModule\Controller\Splitter;

use App\Modules\AdminModule\Controller\AdminController;
use App\Modules\AdminModule\Model\AdminMedia;

//Module Model  
use App\Core\Lib\Uploader;
use App\Middleware\Auth;
use App\Exception\LoraException;
use App\Core\Application\Redirect;
use App\Core\Lib\TextParser;
use App\Core\Lib\FormValidator;


class AdminMediaController extends AdminController 
{
    use Redirect;
    use FormValidator;
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
    protected $model;

    protected AdminMedia $media;

    
    public $title = "";

    
    public function __construct($injector, $model)
    {
        parent::__construct($injector);
        
        $this->module = "admin";
        $this->injector = $injector;
        $this->model = $model;

        $this->media = new AdminMedia();
    }
    
    
    public function mediaIndex(Uploader $upload, TextParser $parser, Auth $auth) 
    {
        $this->data = [
            "user_uid" => $auth->user_uid,
            "text_parser" => $parser,
        ];
        return $this->view = "media/index";
    }

    public function show(TextParser $parser, Auth $auth)
    {
        //Get data from Picture
        $picture = $this->u["param"];
        $picture_name = str_replace("@", ".", $picture);
        $picture = explode(".", $picture_name);

        $this->data = [
            "picture" => $this->media->getPictureData($picture_name),
            "user_uid" => $auth->user_uid,
        ];

        return $this->view = "media/show";
    }

    public function insert(Uploader $uploader, Auth $auth)
    {
        try{
            if (count($_FILES["images"]["size"]) > 0) 
            {
                $uploader->uploadImages("images", "./App/Modules/AdminModule/resources/img/user/".$auth->user_uid);
            }

            @Redirect::redirect("admin/app/media");

        }catch(LoraException $ex){
            @Redirect::previous();
        }
        
    }

    public function pictureDelete(Auth $auth)
    {
        $picture_slug = $this->u["param"];
        $picture_name = str_replace("@", ".", $picture_slug);

        $explo = explode(".", $picture_name);

        $path = "App/Modules/AdminModule/resources/img/user/".$auth->user_uid;
        if(file_exists($path."/thumb/$picture_name"))
        {
            unlink($path."/thumb/".$picture_name);
            unlink($path."/".$picture_name);

            //unlink text file
            if(file_exists($path."/".$explo[0].".txt"))
            {
                unlink($path."/".$explo[0].".txt");
            }
            
        }

        @Redirect::redirect("admin/app/media");
    }

    public function updateAltText(TextParser $text_parser, Auth $auth, LoraException $lora)
    {
         //Fill $post variable with values of form fields
        $post = $this->input("alt_text", "required,maxchars128", "Alternativní text")
        ->input("picture_name", "maxchars256", "Jméno obrázku")->returnFields();

        $alt_text = $post["alt_text"];
        $picture = $post["picture_name"];

        try 
        {
            $this->validate();
            $text_parser->parse("./App/Modules/AdminModule/resources/img/user/".$auth->user_uid."/".$picture.".txt")->set("alt", $alt_text);
            $lora->successMessage("Alternativní text byl upraven");
            @Redirect::previous();
        }catch(LoraException $ex)
        {
            $lora->errorMessage($ex->getMessage());
            @Redirect::previous();
        }
        
    }
}

