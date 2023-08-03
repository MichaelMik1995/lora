<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Executor;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

class LoraUtils 
{
    use Templator;
    use LoraOutput;

    public function __construct()
    {
        
    }


    public static function createUtility(string $util_name)
    {
        $file = file_get_contents(__DIR__."/../../templates/lora_core/utility.template");
        
        $compiled = Templator::compile($file, [
            "{date}" => DATE("d.m.Y H:i:s"),
            "{Utilname}" => ucfirst($util_name),
        ]);

        $util_file = "./App/Core/Lib/Utils/".ucfirst($util_name)."Utils.php";
        if(!file_exists($util_file))
        {
            $handle = fopen("./App/Core/Lib/Utils/".ucfirst($util_name)."Utils.php", "w");
            fwrite($handle, $compiled);
            fclose($handle);

            LoraOutput::output("Utility: $util_file installed successfully", "success");
        }
        else
        {
            LoraOutput::output("Utility: $util_file already exists! Skipping ...", "warning");
        }
    }

}