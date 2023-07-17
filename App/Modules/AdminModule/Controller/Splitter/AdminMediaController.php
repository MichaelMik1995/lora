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
    
    use FormValidator;
    /**
     * @var array <p>Injected classes to controller</p>
     */
    protected $container;
    
    /**
     * @var array <p>Data from URL address (/homepage/show/:url) -> $u['url'] = ?</p>
     */
    public $u;
    
    /**
     * @instance of main model: Shop() of this controller.
     */
    protected $model;

    /**
     * @var string $splitter_title <p>Override default web title with this splitter title</p>
     */
    protected string $splitter_title = "";

    protected AdminMedia $media;

    
    public function __construct($container, $model)
    {
        parent::__construct($container);
        
        $this->module = "admin";
        $this->container = $container;
        $this->model = $model;
    }
    
    
    public function mediaIndex(AdminMedia $media, Uploader $upload, TextParser $parser, Auth $auth) 
    {
        $this->data = [
            "user_uid" => $auth->user_uid,
            "text_parser" => $parser,
            "images" => $media->getImages(),
            "folder_data" => $media->getFolderData(),
        ];

        $this->splitter_title = lang("title_media_index", false);
        return $this->view = "media/index";
    }

    public function show(TextParser $parser, Auth $auth, AdminMedia $media)
    {
        //Get data from Picture
        $picture = $this->u["param"];
        $picture_name = str_replace("@", ".", $picture);
        $picture = explode(".", $picture_name);

        $this->data = [
            "picture" => $media->getPictureData($picture_name),
            "user_uid" => $auth->user_uid,
        ];

        return $this->view = "media/show";
    }

    public function insert(Uploader $uploader, Auth $auth, Redirect $redirect)
    {
        try{
            if (count($_FILES["images"]["size"]) > 0) 
            {
                $uploader->uploadImages("images", "./public/upload/images", 50);
            }

            $redirect->to("admin/app/media");

        }catch(LoraException $ex){
           $redirect->previous();
        }
        
    }

    public function pictureDelete(Auth $auth, Redirect $redirect, LoraException $lora_exception)
    {
        $picture_slug = $this->u["param"];
        $picture_name = str_replace("@", ".", $picture_slug);

        $explo = explode(".", $picture_name);

        $path = "./public/upload/images";
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

        $lora_exception->successMessage("Obrázek byl úspěšně smazán.");
        $redirect->to("admin/app/media");
    }

    public function updateAltText(TextParser $text_parser, Auth $auth, LoraException $lora, Redirect $redirect)
    {
         //Fill $post variable with values of form fields
        $post = $this->input("alt_text", "required,maxchars128", "Alternativní text")
        ->input("picture_name", "maxchars256", "Jméno obrázku")->returnFields();

        $alt_text = $post["alt_text"];
        $picture = $post["picture_name"];

        try 
        {
            $this->validate();
            $text_parser->parse("./public/upload/images/".$picture.".txt")->set("alt", $alt_text);
            $lora->successMessage("Alternativní text byl upraven");
            
        }catch(LoraException $ex)
        {
            $lora->errorMessage($ex->getMessage());
        }
        $redirect->previous();
        
    }

    public function getTitle()
    {
        var_dump($this->splitter_title);
        return $this->splitter_title;
    }
}

