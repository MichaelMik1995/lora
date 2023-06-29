<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;
use App\Core\Interface\InstanceInterface;
use Exception;

/**
 * MediaUtils fo managing files, images, audio, 
 *
 * @author ctyrka
 */
class MediaUtils implements InstanceInterface
{
    private static $_instance;
    private static int $_instance_id;

    private function __construct(){}

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
    
    
    public function uploadOneImage(string $folder, string $post_field_name = "image", string $new_image_name = "", string $new_ext = "none")
    {
        // Získání informací o souboru
        $file = $_FILES[$post_field_name];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];

        // Kontrola, zda byl soubor úspěšně nahrán
        if (!is_uploaded_file($file_tmp)) {
            throw new Exception('Neplatný soubor');
        }

        // Kontrola typu souboru
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception('Neplatný typ souboru. Povolené formáty: ' . implode(', ', $allowed_extensions));
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

        // Přesunutí souboru do určeného adresáře
        if (!move_uploaded_file($file_tmp, $upload_path)) {
            throw new Exception('Nepodařilo se uložit soubor');
        }

        // Návrat cesty k uploadovanému souboru
        return $upload_path;
    }
    
    public function uploadMultipleImages(string $folder, string $post_field_name = "images", int $limit = 8)
    {
        // Získání informací o nahraných souborech
        $files = $_FILES[$post_field_name];

        // Počet nahraných souborů
        $file_count = count($files['name']);

        // Kontrola limitu na počet nahraných souborů
        if ($file_count > $limit) {
            throw new Exception('Překročen limit počtu souborů. Maximální povolený počet: ' . $limit);
        }

        // Pole pro ukládání cest k uploadovaným souborům
        $uploaded_files = [];

        // Iterace přes nahrané soubory
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];

            // Kontrola, zda byl soubor úspěšně nahrán
            if (!is_uploaded_file($file_tmp)) {
                throw new Exception('Neplatný soubor');
            }

            // Získání původního rozšíření souboru
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generování unikátního jména pro soubor
            $new_image_name = uniqid();
            $new_file_name = $new_image_name . '.' . $file_ext;

            // Cesta k adresáři pro upload
            $upload_path = $folder . '/' . $new_file_name;

            // Přesunutí souboru do určeného adresáře
            if (!move_uploaded_file($file_tmp, $upload_path)) {
                throw new Exception('Nepodařilo se uložit soubor');
            }

            // Přidání cesty k uploadovanému souboru do pole
            $uploaded_files[] = $upload_path;
        }

        // Návrat pole s cestami k uploadovaným souborům
        return $uploaded_files;
    }
    
    
    public function uploadGalleryImages($folder, $post_field_name = "images", $thumb_width = null, $thumb_height = null, int|float $thumb_scale = 0.3)
    {
        $files = $this->uploadMultipleImages($folder, $post_field_name);
        
        foreach($files as $file)
        {
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
    * @param int $target_width The target width of the resized image. Default is 256 pixels.
    * @param int $target_height The target height of the resized image. Default is 256 pixels.
    * @return bool Returns true on success, false on failure.
    */
    public function resizeImage($source_image, $image_destination, $new_image_name, $target_width = 256, $target_height = 128, $percent_scale = 0): Bool
    {
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
            "tiff" => imagecreatefromtiff($source_image),
            "default" => null,
        };

        // change resolution of loaded image and copy data to $new_image
        imagecopyresampled($new_image, $source_image_resource, 0, 0, 0, 0, intval($width), intval($height), $source_width, $source_height);
        
        //save new image
        match($image_extension) {
            "jpeg" => imagejpeg($new_image, $image_destination . '/' . $new_image_name. ".jpeg"),
            "jpg" => imagejpeg($new_image, $image_destination . '/' . $new_image_name. ".jpg"),
            "png" => imagepng($new_image, $image_destination . '/' . $new_image_name. ".png"),
            "gif" => imagegif($new_image, $image_destination . '/' . $new_image_name. ".gif"),
            "webp" => imagewebp($new_image, $image_destination . '/' . $new_image_name. ".webp"),
            "bmp" => imagebmp($new_image, $image_destination . '/' . $new_image_name. ".bmp"),
            "tiff" => imagetiff($new_image, $image_destination . '/' . $new_image_name. ".tiff"),
            "default" => null,
        };

        // clear cache
        imagedestroy($new_image);
        imagedestroy($source_image_resource);
        
        return true;
    }
}
