<?php
declare(strict_types=1);

namespace App\Core\Lib;
use App\Core\Interface\InstanceInterface;
use ZipArchive;

class Archiver implements InstanceInterface
{
    private static $_instance = null;
    private static $_instance_id;

    private function __construct(
        private ZipArchive $zipper = new ZipArchive()
        ){}

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $zip_name
     * @param boolean $delete_source
     * @return bool
     */
    public function zip(string $path, string $zip_name, bool $delete_source = false): Bool
    {
        if($delete_source == true)
        {
            $files_to_delete = [];
        }

        $zip = $this->zipper;
        $zip->open($zip_name, ZipArchive::CREATE);

        if(is_dir($path))
        { 
            foreach(glob($path."/*") as $file)
            {
                if(file_exists($file) && is_file($file))
                {
                    $zip->addFile($file, basename($file));
                }

                if($delete_source == true && !is_dir($file))
                {
                    if(is_dir($path) & ($path != $file))
                    {
                        $files_to_delete[] = $file;
                    }
                }	
            }
        }
        else{
            $zip->addFile($path);

            if($delete_source == true)
            {
                $files_to_delete[] = $path;
            }
        }

        $zip->close();

        foreach($files_to_delete as $file)
        {
            unlink($file);
        }

        return true;
    }

    public function unzip($zip_name, $path)
    {
        $zip = $this->zipper;
        $zip->open($zip_name);
        $zip->extractTo($path);
        $zip->close();
    }
}