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
use App\Core\Lib\TextParser;
use App\Core\Lib\Utils\MediaUtils;

//Model
use App\Modules\UserModule\Model\UserGallery;


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
class UserGalleryController extends UserController 
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
    private string $template_folder = "gallery/";

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
    public function galleryIndex(UserGallery $gallery, Auth $auth, TextParser $parser) 
    {
        $gallery_images = $gallery->getUserGallery($auth->user_uid);
        $folder_data = $gallery->getUploadFolderData($auth->user_uid);

        $this->data = [
            "gallery" => $gallery_images,
            "upload_folder" => $gallery->getUploadFolder($auth->user_uid),
            "text_parser" => $parser,
            "folder_data" => $folder_data,
        ]; 

        return $this->view = $this->template_folder."index";
    }

    /**
     * Can use for viewing one table (row) in template
     * @return string
     */
    public function imageShow(UserGallery $gallery, Auth $auth, TextParser $parser) 
    {
       //Get data from Picture
       $picture = $this->u["param"];
       $picture_name = str_replace("@", ".", $picture);
       $picture = explode(".", $picture_name);

       $this->data = [
           "picture" => $gallery->getPictureData($auth->user_uid, $picture_name),
           "upload_folder" => $gallery->getUploadFolder($auth->user_uid),
           "user_uid" => $gallery->user_uid,
       ];

        return $this->view = $this->template_folder."show";
    }

    /**
     * Can use for viewing form to create a new row
     * @return void
     */
    public function imagesInsert(UserGallery $gallery, Auth $auth, EasyText $easy_text, MediaUtils $media_utils, LoraException $exception, Redirect $redirect)
    {
        $upload_folder = $gallery->getUploadFolder($auth->user_uid);
        $folder_data = $gallery->getUploadFolderData($auth->user_uid);

        $count_images = $folder_data["count"] + count($_FILES["images"]["size"]);

        try{
            if (count($_FILES["images"]["size"]) > 0) 
            {
                if($count_images <= env("max_uploaded_images", false) || $auth->is_admin == true)
                {
                    $media_utils->uploadGalleryImages("content/uploads/$upload_folder/images", "images", "256");
                }
                else
                {
                    $exception->errorMessage("V galerii může být maximálně ".env("max_uploaded_images", false)." obrázků.");
                    $redirect->previous();
                }

                
            }

            $redirect->to("user/app/gallery");

        }catch(LoraException $ex){
           $redirect->previous();
        }
    }

    public function updateAltImage(UserGallery $gallery, TextParser $text_parser, Auth $auth, LoraException $lora, Redirect $redirect, StringUtils $string_utils)
    {
        $upload_folder = $gallery->getUploadFolder($auth->user_uid);

        //Fill $post variable with values of form fields
        $post = $this->input("alt_text", "required,maxchars128", "Alternativní text")
        ->input("picture_name", "maxchars256", "Jméno obrázku")->returnFields();

        $alt_text = $post["alt_text"];
        $picture = $post["picture_name"];

        try 
        {
            $this->validate();
            $text_parser->parse("./content/uploads/$upload_folder/images/".$picture.".txt")->set("alt", $string_utils->toSlug($alt_text, true));
            $lora->successMessage("Alternativní text byl upraven");
            
        }catch(LoraException $ex)
        {
            $lora->errorMessage($ex->getMessage());
        }

        $redirect->previous();
    }

    public function imageDelete(UserGallery $gallery, Auth $auth, Redirect $redirect, LoraException $lora_exception)
    {
        $upload_folder = $gallery->getUploadFolder($auth->user_uid);

        $picture_slug = $this->u["param"];
        $picture_name = str_replace("@", ".", $picture_slug);

        $explo = explode(".", $picture_name);

        $path = "./content/uploads/$upload_folder/images";

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
        $redirect->to("user/app/gallery");
    }

}

