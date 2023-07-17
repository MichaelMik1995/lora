<?php
/**
 * Description of Module Model - UserGallery:
 *
 * This model was created for module: User
 * @author MiroJi
 * Created_at: 1689059617
 */
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

/**
*   Using main module Model
*/
use App\Modules\UserModule\Model\User;
use App\Core\Database\Database;

//Interface
use App\Core\Interface\ModelDBInterface;
use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\Utils\FileUtils;

//Core
use App\Core\DI\DIContainer;

class UserGallery extends User implements ModelDBInterface
{
    protected array|null $model_data;

    public function __construct(DIContainer $container) //Can expand to multiple arguments, first must be DIContainer
    {
        parent::__construct($container);    //Only this one argument is needed
    }


    public function getUploadFolder($uid): string
    {
        $string_utils = $this->string_utils;
        return $string_utils->generateHashFromString($uid, md5($uid.$uid), 26);
    }
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function getUserGallery(string|int $uid): Array
    {
        //Hash folder for hide UID
        $hashed_content_folder = $this->getUploadFolder($uid);

        $path = "./content/uploads/$hashed_content_folder";

        if(!is_dir($path))
        {
            //Create upload folder if not exist
            $this->createUploadFolder($uid, $hashed_content_folder);
        }

        if(!is_dir($path."/images"))
        {
            mkdir($path."/images", 0700, true);
            mkdir($path."/images/thumb", 0700, true);
        }

        $images = scandir($path."/images", SCANDIR_SORT_DESCENDING);
        $gallery = [];

        foreach($images as $image)
        {
            if($image != "." && $image != "..")
            {
                if($image != "thumb" && (
                    str_contains($image, ".png") || 
                    str_contains($image, ".jpg") || 
                    str_contains($image, ".jpeg") || 
                    str_contains($image, ".gif") ||
                    str_contains($image, ".webp")
                    )
                )
                {
                    
                    $gallery[] = $path."/images/thumb/".$image;
                }
                
            }
        }

        return $gallery;
        
    }

    /**
     * Undocumented function
     *
     * @param string|integer $uid
     * @return array
     */
    public function getUploadFolderData(string|int $uid): Array
    {
        //Hash folder for hide UID
        $hashed_content_folder = $this->getUploadFolder($uid);
        $folder = "./content/uploads/$hashed_content_folder/images/";

        $scan_folder = scandir($folder, SCANDIR_SORT_DESCENDING);

        $i = 0;
        foreach($scan_folder as $file)
        {
            if($file!= "." && $file!= ".." && $file!= "thumb")
            {
                $image = $file;
                if(
                    str_contains($image, ".png") || 
                    str_contains($image, ".jpg") || 
                    str_contains($image, ".jpeg") || 
                    str_contains($image, ".gif") ||
                    str_contains($image, ".webp") 
                )
                {
                    $i++;
                }
            }
        }

        
        $folder_size = $this->number_utils->real_filesize($this->container->get(FileUtils::class)->GetDirectorySize($folder));


        $return_data = [
            "folder" => $folder,
            "folder_size" => $folder_size,
            "count" => $i,
        ];

        $this->model_data = $return_data;
        return $return_data;
    }
    
    public function insertPicture(array $insert_values)
    {
        // Insert new row
        
    }
    
    public function updateAltData(array $set, string $url)
    {
        // update row
       
    }
    
    public function deletePicture(string $url)
    {
        // delete row
    }

    /**
     * Get Admin Picture Data from source
     * @param string $picture_name
     */
    public function getPictureData(string|int $uid, string $picture_name): Array
    {
        $hashed_content_folder = $this->getUploadFolder($uid);
        $folder = "./content/uploads/$hashed_content_folder/images";

        $filename = $folder."/".$picture_name;

        if(file_exists($filename))
        {

            $picture_explo = explode(".", $picture_name);

            // Get File Size
            $filesize = $this->number_utils->real_filesize(filesize($filename));

            // Get MIME Type info
            $filetype = mime_content_type($filename);

            // Get Image resolution information
            $dimensions = getimagesize($filename);
            $width = $dimensions[0];
            $height = $dimensions[1];

            // Get EXIF Information if available
            $exifData = @exif_read_data($filename);

            $alt_text_file = $folder."/".$picture_explo[0].".txt";

            
            $file_info = file_get_contents($alt_text_file);

            $file_explode = explode("\n", $file_info);

            foreach($file_explode as $line)
            {
                $generated_data[] =  explode("=", $line); 

            }


            if($exifData !== false)
            {
                $exif_data = $exifData;
            }
            else
            {
                $exif_data = [];
            }



            return [
                "filename" => $picture_explo[0],
                "file_extension" => $picture_explo[1],
                "filesize" => $filesize,
                "filetype" => $filetype,
                "width" => $width,
                "height" => $height,
                "exifdata" => $exif_data,
                "alt_text" => $generated_data[3][1],
            ];
        }
        else
        {
            return [];
        }
    }

    /** MAGICAL METHODS **/
    public function __set($name, $value) {
        $this->model_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->model_data[$name])) {
            return $this->model_data[$name];
        }
        return null;
    }

    private function createUploadFolder(string|int $uid, string $hashed_folder): bool
    {
        $user = $uid;

        $folder = "./content/uploads/$hashed_folder/";
        mkdir($folder, 0700, true);
        chmod($folder, 0700);
        chown($folder, $user);
        return true;
    }
} 

