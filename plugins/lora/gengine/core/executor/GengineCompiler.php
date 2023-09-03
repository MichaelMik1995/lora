<?php
declare(strict_types=1);

namespace Lora\Gengine\Core\Executor;
use App\Core\Interface\InstanceInterface;
use Lora\Lora\Core\LoraOutput;

class GengineCompiler implements InstanceInterface
{
    use LoraOutput;

    public string $source_folder;
    public string $destination_folder;

    private static $_instance;
    private static $_instance_id;

    private array $compiler_data;

    private LoraOutput $lora_output;

    public function __construct()
    {
        $this->source_folder =      "./plugins/lora/gengine/src/tsc";
        $this->destination_folder = "./plugins/lora/gengine/src/js";
    }
    public function __constructor()
    {
    }

    public static function instance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
            self::$_instance_id = uniqid();
        }

        return self::$_instance;
    }

    public function getInstanceId()
    {
        return self::$_instance_id;
    }


    /* Compiler Methods */
    public function compileTS($sourceDir = null, $targetDir = null) 
    {
        /*if($sourceDir === null) $sourceDir = $this->source_folder;
        if($targetDir === null) $targetDir = $this->destination_folder;

        // Vytvoř cílovou složku, pokud ještě neexistuje
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        $files = scandir($sourceDir);
    
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
    
            $sourcePath = $sourceDir . '/' . $file;
            $targetPath = $targetDir . '/' . $file;
    
            if (is_dir($sourcePath)) {
                $this->compileTS($sourcePath, $targetPath); // Rekurzivně zpracuj podsložku
            } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'ts') {
                // Zde je potřeba implementovat volání TypeScript kompilátoru (tsc)
                // Například pomocí funkce shell_exec() nebo exec()
                shell_exec('tsc ' . $sourcePath . ' -outDir ' . $targetDir);
                // Ujisti se, že máš TypeScript kompilátor nainstalovaný a přístupný z příkazové řádky
            } else {
                // Pokud není soubor .ts, jen ho zkopíruj do cílové složky
                copy($sourcePath, $targetPath);
            }
        }*/

        shell_exec("tsc");
    }

    /** MAGICAL METHODS **/
    public function __set($name, $value) {
        $this->compiler_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->compiler_data[$name])) {
            return $this->compiler_data[$name];
        }
        return null;
    }

}