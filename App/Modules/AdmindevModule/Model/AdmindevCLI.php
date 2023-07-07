<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Model;

use App\Modules\AdmindevModule\Model\Admindev;

class AdmindevCLI extends Admindev
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getLog(): Array
    {
        $db_query = $this->database->select("admin-cli-log", "id!=? ORDER BY id DESC", [0]);
        if(!empty($db_query))
        {
            $i = 0;
            foreach($db_query as $row)
            {
                $id = $i++;
                $cmd_output = $row["cmd_output"];
                $db_query[$id]["_output"] = $this->colorize($cmd_output);
            }
            return $db_query;
        }
        else
        {
            return [];
        }
    }

    public function executeCommand(string $command, string $type = "default")
    {
        $output = shell_exec($command);

        $this->database->insert("admin-cli-log", [
            "cmd_execute" => $command,
            "cmd_output" => $output,
            "cmd_type" => $type,
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        //file open
        $file = fopen("./log/cli.log", "w+");
        fwrite($file, $command."\n".$output);
        fclose($file);
        return true;
    }


    private function colorize(string|null $string): String|Null
    {
        if($string != null)
        {
            $translator = [
                "\033[39m" => "<span class='t-light'>",
                "\033[34m" => "<span class='t-info'>",
                "\033[32m" => "<span class='t-success'>",
                "[1;32;40m" => "<span class='t-create t-bold'>",
                "\033[91m" => "<span class='t-error'>",
                "[1;33;40m" => "<span class='t-warning'>",
                "[0m" => "</span>",
                "\n" => "<br>",
            ];
    
            return strtr($string, $translator);
        }
        else
        {
            return null;
        }
        
    }
}