<?php
namespace App\Core\Lib;
use App\Exception\LoraException;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */


/**
 * Description of Uploader
 *
 * @author miroji
 */
class Uploader
{
    protected $input_name;
    protected $max_file_size_image;
    public $upload_dir = "";

    private static $_instance = null;
    private static $_instance_id;

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }

        return self::$_instance;
    }

    
    /**
     * 
     * @param string $varFiles      <p>string value from <input type='file'> </p>
     * @param string $path            <p>Where to upload image with thumb (./public/img/$path - /thumb/)</p>
     * @param string $new_filename    <p>New filename of uploaded image</p>
     * @param string $file_extension  <p>File extension (default.: "" = extension of uploaded file) Avaliable: png,bmp,jpg,gif</p>
     * @return boolean
     * @throws LoraException
     */
    public function uploadImage(string $varFiles, string $path, string $new_filename = "", $file_extension = "") 
    {

        // Looping all files

            $filename = $_FILES[$varFiles]['name'];
            
            // create THUMB
            $this->resize_image(
                    $_FILES[$varFiles]['type'],
                    $_FILES[$varFiles]['tmp_name'],
                    $_FILES[$varFiles]['name'],
                    $this->upload_dir . $path . "/thumb/"
            );
            
            if($new_filename == "")
            {
                $filenameGenerateName = rand(00000000, 99999999);
            }
            else
            {
                $filenameGenerateName = $new_filename;
            }
            
            if($file_extension == "")
            {
                $path_parts_thumb = pathinfo($path . "/thumb/".$filename);
                $extension = $path_parts_thumb['extension'];
            }
            else
            {
                $extension = $file_extension;
            }
            
            
            
            $move = move_uploaded_file($_FILES[$varFiles]['tmp_name'], $this->upload_dir . $path . "/" . $filename);
            
            if($move == true)
            {
                rename($this->upload_dir . $path . "/thumb/" . $filename, $this->upload_dir . $path . "/thumb/".$filenameGenerateName.".".$extension);//.$path_parts_thumb['extension']);
                    
                    //rename image
                rename($this->upload_dir . $path . "/" . $filename, $this->upload_dir . $path . "/" . $filenameGenerateName.".".$extension);//.$path_parts_thumb['extension']);
                    
                return true;
            }
            else
            {
                throw new LoraException("Chyba při přesouvání obrázku: ".$this->upload_dir . $path . "/" . $_FILES[$varFiles]['name']);
            }
    }
    
    /**
     * 
     * @param string $varFiles <p>string value from <input type='file'> </p>
     * @param string $path    <p>Where to upload full image (NO thumb) (./public/img/$path)</p>
     * @return boolean </p>Returns true | throw</p>
     * @throws LoraException
     */
    public function uploadImages($varFiles, $path="", int $max_images = 8) 
    {
        

        // Count total files
        $countfiles = count($_FILES[$varFiles]['name']);
        
        if($countfiles > $max_images)
        {
            throw new LoraException("Počet vybraných obrázků k nahrání může být max. $max_images !");
        }
        else
        {
            ini_set('upload_max_filesize', '20M');
            ini_set('post_max_size', '200M');
            ini_set('max_file_uploads', $max_images);

            foreach ($_FILES[$varFiles]['name'] as $key => $val) 
            {
                
                $filename = basename($_FILES[$varFiles]['name'][$key]);

                if(! ($this->resize_image(
                    $_FILES[$varFiles]['type'][$key],
                    $_FILES[$varFiles]['tmp_name'][$key],
                    $_FILES[$varFiles]['name'][$key],
                    $this->upload_dir . $path . "/thumb/"
                )))
                {
                    throw new LoraException("Chyba při změně rozlišení: ".$this->upload_dir. $path. "/". $_FILES[$varFiles]['name'][$key]);
                }

                $filenameGenerateName = substr(hash("sha256", rand(00000, 99999)), 0, 7);
                $path_parts_thumb = pathinfo($path . "/thumb/" . $filename);

                if(!move_uploaded_file($_FILES[$varFiles]['tmp_name'][$key], $this->upload_dir . $path . "/" . $filename))
                {
                    throw new LoraException("Chyba při přesouvání obrázku: ".$this->upload_dir. $path. "/". $_FILES[$varFiles]['name'][$key]);
                }

                rename($this->upload_dir . $path . "/thumb/" . $filename, $this->upload_dir . $path . "/thumb/" . $filenameGenerateName . "." . $path_parts_thumb['extension']);

                //rename image
                rename($this->upload_dir . $path . "/" . $filename, $this->upload_dir . $path . "/" . $filenameGenerateName . "." . $path_parts_thumb['extension']);
                
                //Create Image info file
                if(!file_exists($this->upload_dir . $path . "/" . $filenameGenerateName. ".txt"))
                {
                    $file = fopen($this->upload_dir . $path . "/" . $filenameGenerateName. ".txt", "w");
                    fwrite($file,"original_name=$filename\ngenerated_name=$filenameGenerateName\nextension=".$path_parts_thumb['extension']."\nalt=Write alternative text for this picture"
                    );
                    fclose($file);
                }

                
            }

            
            return true;
        }
    }
    
    public function uploadAvatar($varFile, $uid) 
    {
        $uploadAvatar = $this->resize_image_avatar(
                $_FILES[$varFile]['type'],
                $_FILES[$varFile]['tmp_name'],
                $uid,
                "./public/img/avatar/",
                256,
                256
        );
    }

    public function generateImageData($path, $filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if(file_exists($path."/".$filename.".txt"))
        {
            $file = fopen($path."/".$filename.".txt", "w");
            fwrite($file,"original_name=$filename\ngenerated_name=$filename\nextension=".$ext."\nalt=Write alternative text for this picture"
                        );
            fclose($file);
        }
    }
    
    private function resize_image($imageType, $imageTmpName, $imageName, $path, $width = 256, $height = 256) 
    {

        switch (strtolower($imageType)) 
        {
            case 'image/jpeg':
                $imageRes = imagecreatefromjpeg($imageTmpName);
                break;
            
            case 'image/png':
                $imageRes = imagecreatefrompng($imageTmpName);
                break;
            
            case 'image/gif':
                $imageRes = imagecreatefromgif($imageTmpName);
                break;
            
            case 'image/bmp':
                $imageRes = imagecreatefrombmp($imageTmpName);
                break;
            
            case 'image/webp':
                $imageRes = imagecreatefromwebp($imageTmpName);
                break;
            
            default:
                throw new LoraException('Neznámý typ formátu obrázku: ' . $imageType.". Jsou povoleny pouze BMP PNG JPG GIF");
        }

        
        
        // Set max dimension of picture
        $max_width = $width;
        $max_height = $height;

        // Get current dimensions
        $old_width = imagesx($imageRes);
        $old_height = imagesy($imageRes);
        echo $old_width;
        
        if($old_width == "")
        {
            throw new LoraException("Neznámý typ formátu");
        }

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale = min($max_width / $old_width, $max_height / $old_height);

        // Get the new dimensions
        $new_width = ceil($scale * $old_width);
        $new_height = ceil($scale * $old_height);

        // Create new empty image
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $imageRes,
                0, 0, 0, 0,
                $new_width, $new_height, $old_width, $old_height);
        
        switch(strtolower($imageType))
        {
            case 'image/jpeg':
                imagejpeg($new, $path . $imageName);
                break;
            
            case 'image/png':
                imagepng($new, $path . $imageName);
                break;
            
            case 'image/gif':
                imagegif($new, $path . $imageName);
                break;
            
            case 'image/bmp':
                imagebmp($new, $path . $imageName);
                break;
            
            case 'image/webp':
                imagewebp($new, $path . $imageName);
                break;
        }
        
        return true;
        
    }
    
    private function resize_image_avatar($imageType, $imageTmpName, $imageName, $path, $width = 256, $height = 256) 
    {
        switch (strtolower($imageType)) 
        {
            case 'image/jpeg':
                $imageRes = imagecreatefromjpeg($imageTmpName);
                break;
            
            case 'image/png':
                $imageRes = imagecreatefrompng($imageTmpName);
                break;
            
            case 'image/gif':
                $imageRes = imagecreatefromgif($imageTmpName);
                break;
            
            case 'image/bmp':
                $imageRes = imagecreatefrombmp($imageTmpName);
                break;
            
            default:
                return false;
                exit('Neznámý typ formátu obrázku: ' . $imageType.". Jsou povoleny pouze BMP PNG JPG GIF");
        }
        
        // Set max dimension of picture
        $max_width = $width;
        $max_height = $height;

        // Get current dimensions
        $old_width = imagesx($imageRes);
        $old_height = imagesy($imageRes);

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale = min($max_width / $old_width, $max_height / $old_height);

        // Get the new dimensions
        $new_width = ceil($scale * $old_width);
        $new_height = ceil($scale * $old_height);

        // Create new empty image
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $imageRes,
                0, 0, 0, 0,
                $new_width, $new_height, $old_width, $old_height);
        
        
        imagepng($new, $path . $imageName.".png");
        
        return true;
        
    }
    
    public function folderSize($dir) {
        $size = 0;

        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }

        return $size;
    }
    
    private function checkFileSize($checked_file_size)
    {
        
    }
    
    private function checkFileType($checked_file_type, array $avaliable_types)
    {
        
    }
}
