<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;
use App\Core\Interface\InstanceInterface;
use App\Exception\LoraException;
use Exception;
use App\Core\Lib\Logger;
use App\Core\DI\DIContainer;

/**
 * MediaUtils fo managing files, images, audio, 
 *
 * @author ctyrka
 */
class MediaUtils implements InstanceInterface
{
    private static $_instance;
    private static int $_instance_id;

    private Logger $log;

    public function __construct(){}

    /**
     * Arguments will be inserted via DI
     */
    public function __constructor(Logger $log)
    {
        $this->log = $log;
    }

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Returns an instance id
     */
    public function getInstanceId(): Int
    {
        return self::$_instance_id;
    }
    
    /* Images */
    
    /**
     * Upload one image to the specified folder
     *
     * @param string $folder            <p>Path to upload image</p>
     * @param string $post_field_name   <p>NAME attribute value from POST form</p>
     * @param string $new_image_name    <p>If defined -> sets specific name of new image</p>
     * @param string $new_ext           <p>If defined -> rewrites image extension (for example "png")</p>
     * @return string|null              <p>returns full path of uploaded image with name and extension</p>
     */
    public function uploadOneImage(string $folder, string $post_field_name = "image", string $new_image_name = "", string $new_ext = "none")
    {
        // Collecting information from uploaded image
        $file = $_FILES[$post_field_name];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];

        // Kontrola, zda byl soubor úspěšně nahrán
        if (!is_uploaded_file($file_tmp)) {
            throw new Exception('Soubor se nepodařilo nahrát!');
        }

        // Kontrola typu souboru
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception('Neplatný typ nahráváného obrázku. Povolené formáty: ' . implode(', ', $allowed_extensions));
        }

        // Pokud je $new_image_name prázdný, vygeneruj nové jméno souboru
        if (empty($new_image_name)) {
            $new_image_name = uniqid();
        }

        // Pokud je $new_ext "none", použij původní rozšíření
        if ($new_ext === "none") {
            $new_ext = $file_ext;
        }

        // Vytvoření nového jména souboru s rozšířením
        $new_file_name = $new_image_name . '.' . $new_ext;

        // Cesta k adresáři pro upload
        $upload_path = $folder . '/' . $new_file_name;

        //Přesunutí souboru do určeného adresáře
        if (!move_uploaded_file($file_tmp, $upload_path)) {
            throw new Exception('Nepodařilo se uložit soubor');
        }

        $this->createMetadata($new_image_name, $folder, $new_ext, $file_name);

        // Návrat cesty k uploadovanému souboru
        return $upload_path;
    }
    
    public function uploadMultipleImages(string $folder, string $post_field_name = "images", int $limit = 8)
    {
        // Získání informací o nahraných souborech
        $files = $_FILES[$post_field_name];

        // Počet nahraných souborů
        $file_count = count($files['name']);

        if($file_count <= 0)
        {
            return;
        }

        // Kontrola limitu na počet nahraných souborů
        if ($file_count > $limit) {
            throw new Exception('Překročen limit počtu souborů. Maximální povolený počet: ' . $limit);
        }

        // Pole pro ukládání cest k uploadovaným souborům
        $uploaded_files = [];

        // Iterace přes nahrané soubory
        for ($i = 0; $i < $file_count; $i++) 
        {
            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];

            // Kontrola, zda byl soubor úspěšně nahrán
            /*if (!is_uploaded_file($file_tmp)) {
                throw new Exception('Neplatný soubor');
            }*/

            // Získání původního rozšíření souboru
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generování unikátního jména pro soubor
            $new_image_name = uniqid();
            $new_file_name = $new_image_name . '.' . $file_ext;

            // Cesta k adresáři pro upload
            $upload_path = $folder . '/' . $new_file_name;

            // Přesunutí souboru do určeného adresáře
            if (!move_uploaded_file($file_tmp, $upload_path)) {
            
                throw new Exception('Nepodařilo se uložit soubor'.$file_tmp);
            }

            // Přidání cesty k uploadovanému souboru do pole
            $uploaded_files[] = $upload_path;

            $this->createMetadata($new_image_name, $folder, $file_ext, $file_name);
        }

        // Návrat pole s cestami k uploadovaným souborům
        return $uploaded_files;
    }
    
    /**
     * Upload images to gallery with thumbs and metadata files
     *
     * @param string $folder                    <p>Folder to upload images (! PATH is NOT begining with "./" and ends with "/")</p>
     * @param string $post_field_name           <p>Name of field from form with attribute enctype ex.: images</p>
     * @param string|int|float $thumb_width     <p>Set width of thumb</p>
     * @param string|int|float $thumb_height    <p>OR Set height of thumb</p>
     * @param string|int|float $thumb_scale     <p>OR set scale of image from source</p>
     * @return void
     */
    public function uploadGalleryImages(string $folder, string $post_field_name = "images", string|int|float $thumb_width = null, string|int|float $thumb_height = null, string|int|float $thumb_scale = 0.3)
    {
        $files = $this->uploadMultipleImages($folder, $post_field_name);
        
        foreach($files as $file)
        {
            //if is dot on first position -> delete

            $explode_image = explode(".", $file);
            $explode_path = explode("/", $explode_image[0]);
            
            $revert = array_reverse($explode_path);
            
            $this->resizeImage($file, $folder."/thumb", $revert[0], $thumb_width, $thumb_height, $thumb_scale);
        }
        
    }
    
    /**
    * Resize an existing image and save it to the specified destination.
    *
    * @param string $source_image The path to the source image.
    * @param string $image_destination The destination folder where the resized image will be saved.
    * @param string $new_image_name The name of the resized image.
    * @param int|null $target_width The target width of the resized image. Default is 256 pixels.
    * @param int|null $target_height The target height of the resized image. Default is 256 pixels.
    * @return bool Returns true on success, false on failure.
    */
    public function resizeImage($source_image, $image_destination, mixed $new_image_name, $target_width = 256, $target_height = 128, $percent_scale = 0): Bool
    {
        if(!file_exists($source_image))
        {
            throw new LoraException("Obrázek: ".$source_image." nelze najít");
        }

        // get image extension
        $image_extension = pathinfo($source_image, PATHINFO_EXTENSION);

        // source image width, height (extract array to variables )
        list($source_width, $source_height) = getimagesize($source_image);
        
        // Výpočet nových rozměrů obrázku
        if ($percent_scale != 0) 
        {
            $width = $source_width * $percent_scale;
            $height = $source_height * $percent_scale;
        } 
        else 
        {
            
            if($target_width != null && $target_height == null) //scale by width
            {
                //create percent from subtract
                $width = $target_width;
                $height = round($target_width * $source_height / $source_width);
            }
            elseif($target_height != null && $target_width == null) //scale by height
            {
                $width = round($target_height* $source_width / $source_height);
                $height = $target_height;
            }
            elseif($target_width != null && $target_height == null) //default scaling
            {
                $width = $source_width * 0.5;
                $height = $source_height * 0.5;
            }
            else
            {
                $width = $target_width;
                $height = $target_height;
            }
            
        }

        

        // Creating new image with target width,height
        $new_image = imagecreatetruecolor(intval($width), intval($height));
        
        // Enable alpha blending for PNG images
        if ($image_extension === 'png') {
            imagesavealpha($new_image, true);
            $transparent_color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagefill($new_image, 0, 0, $transparent_color);
        }

        //loading source image to variable
        $source_image_resource = match($image_extension)
        {
            "jpeg" => imagecreatefromjpeg($source_image),
            "jpg" => imagecreatefromjpeg($source_image),
            "png" => imagecreatefrompng($source_image),
            "gif" => imagecreatefromgif($source_image),
            "webp" => imagecreatefromwebp($source_image),
            "bmp" => imagecreatefrombmp($source_image),
            //"tiff" => imagecreatefromtiff($source_image),
            "default" => null,
        };

        // change resolution of loaded image and copy data to $new_image
        imagecopyresampled($new_image, $source_image_resource, 0, 0, 0, 0, intval($width), intval($height), $source_width, $source_height);

        echo $image_destination . '/' . $new_image_name;
        
        //save new image
        match($image_extension) {
            "jpeg" => imagejpeg($new_image, $image_destination . '/' . $new_image_name. ".jpeg"),
            "jpg" => imagejpeg($new_image, $image_destination . '/' . $new_image_name. ".jpg"),
            "png" => imagepng($new_image, $image_destination . '/' . $new_image_name. ".png"),
            "gif" => imagegif($new_image, $image_destination . '/' . $new_image_name. ".gif"),
            "webp" => imagewebp($new_image, $image_destination . '/' . $new_image_name. ".webp"),
            "bmp" => imagebmp($new_image, $image_destination . '/' . $new_image_name. ".bmp"),
            //"tiff" => imagetiff($new_image, $image_destination . '/' . $new_image_name. ".tiff"),
            "default" => null,
        };

        // clear cache
        imagedestroy($new_image);
        imagedestroy($source_image_resource);
        
        return true;
    }

    public function createMetadata(string $image_name, string $image_path, string $image_extension = "", string $source_name = "")
    {
        //Create Image info file
        if(!file_exists($image_path . "/" . $image_name. ".txt"))
        {
            $file = fopen($image_path . "/" . $image_name. ".txt", "w");
            fwrite($file,"original_name=$source_name\ngenerated_name=$image_name\nextension=".$image_extension."\nalt=Write alternative text for this picture"
            );
            fclose($file);
        }
    }

    /**
     * Get ONE image per name ()
     *
     * @param string $folder
     * @param string $name
     * @param int $limit
     * @return string|null|array
     */
    public function getImagesByName(string $folder, string $name, int $limit = 1): String|Null|Array
    {
        
        $folderPath = $folder . '/';
        $mainImagePath = $folderPath . $name . '.*';

        $matchingFiles = glob($mainImagePath);

        if (!empty($matchingFiles)) 
        {
            // Pokud je limit nastaven na 1 a byl nalezen alespoň jeden soubor
            if ($limit === 1) {
                return $matchingFiles[0]; // Vrátíme první nalezený soubor
            }
            // Pokud je limit větší než 1 nebo roven -1
            elseif ($limit > 1 || $limit === -1) {
                // Omezení počtu výsledků podle limitu nebo zobrazení všech výsledků, pokud je limit -1
                if ($limit === -1 || $limit > count($matchingFiles)) {
                    return $matchingFiles; // Vrátíme všechny nalezené soubory
                } else {
                    return array_slice($matchingFiles, 0, $limit); // Vrátíme prvních $limit souborů
                }
            }
        }

        return null; // Pokud žádný soubor nebyl nalezen
    }
}
