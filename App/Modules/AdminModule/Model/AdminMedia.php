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

class AdminMedia extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get Admin Picture Data from source
     * @param string $picture_name
     */
    public function getPictureData(string $picture_name): Array
    {

        $filename = "./App/Modules/AdminModule/resources/img/user/".$this->auth->user_uid."/".$picture_name;

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

            $alt_text_file = "./App/Modules/AdminModule/resources/img/user/".$this->auth->user_uid."/".$picture_explo[0].".txt";

            
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


} 

