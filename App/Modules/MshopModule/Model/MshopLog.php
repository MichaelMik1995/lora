<?php

declare (strict_types=1);

namespace App\Modules\MshopModule\Model;

use App\Core\Model;

/**
 * Description of MshopLog module model
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class MshopLog extends Model 
{
    protected $file_content;
    
    public function getLog(string $log_file = "application")
    {
        $file_path = "./log/";
        $file_ext = ".log";
        
        $this->file_content = file_get_contents($file_path.$log_file.$file_ext);
        $this->compileFile();
        
        $log = $this->file_content;
        
        $lines = rtrim($log, "<br>");
        $lines = explode("<br>", $log);
        
        $return = [];
        
        $i = 0;
        foreach($lines as $line)
        {
            $id = $i++;
            $explode = explode("!?:", $line);
            
            $array_line = array_filter($explode);
            
            if(!empty($array_line))
            {
                $return[$id]["DATE"] = $array_line[1];
                $return[$id]["TYPE"] = $array_line[2];
                $return[$id]["MESSAGE"] = $array_line[3];
            }
        }

        return $return;
    }
    
    private function compileFile()
    {
        $this->file_content = preg_replace('~\@product_code\s*(.+?)\s*\@~is', '<a href="/mshop/manager/manager-product-show/$1" target="_blank" class="t-italic t-warning">$1</a>', $this->file_content);
        $this->file_content = preg_replace('~\@orderid\s*(.+?)\s*\@~is', '<a href="/mshop/manager/order-show/$1" target="_blank" class="t-italic t-warning">$1</a>', $this->file_content);

        
        $this->file_content = str_replace("\n", "<br>", $this->file_content);
    }
}
