<?php
/**
 * Description of Module Model - AdminMedia:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1686213335
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;
use App\Core\DI\DIContainer;
use App\Core\Lib\Utils\FileUtils;

class AdminMedia extends Admin
{
    private $_instance_id;
    private $media_path = "public/upload/images";

    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
        $this->_instance_id = rand(000000,99999);
    }


    public function getInstanceId()
    {
        return $this->_instance_id;
    }


    public function getImages()
    {

        $images = scandir($this->media_path, SCANDIR_SORT_DESCENDING);
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
                    
                    $gallery[] = $this->media_path."/thumb/".$image;
                }
                
            }
        }

        return $gallery;

    }

    public function getFolderData()
    {
        $scan_folder = scandir($this->media_path, SCANDIR_SORT_DESCENDING);

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

        
        $folder_size = $this->number_utils->real_filesize($this->container->get(FileUtils::class)->GetDirectorySize($this->media_path));


        $return_data = [
            "folder" => $this->media_path,
            "folder_size" => $folder_size,
            "count" => $i,
        ];

        return $return_data;
    }

    /**
     * Get Admin Picture Data from source
     * @param string $picture_name
     */
    public function getPictureData(string $picture_name): Array
    {

        $filename = $this->media_path."/".$picture_name;

        if(file_exists($filename))
        {

            $picture_explo = explode(".", $picture_name);

            // Get File Size
            $filesize = filesize($filename);

            // Get MIME Type info
            $filetype = mime_content_type($filename);

            // Get Image resolution information
            $dimensions = getimagesize($filename);
            $width = $dimensions[0];
            $height = $dimensions[1];

            // Get EXIF Information if available
            $exifData = @exif_read_data($filename);

            $alt_text_file = $this->media_path."/".$picture_explo[0].".txt";

            
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
                "filesize" => $this->number_utils->real_filesize($filesize),
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


} 

