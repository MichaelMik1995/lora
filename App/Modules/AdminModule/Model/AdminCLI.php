<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Modules\AdminModule\Model\Admin;
use App\Core\DI\DIContainer;

class AdminCLI extends Admin
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }

    public function getLog(): Array
    {
        $db_query = $this->database->select("admin-cli-log", "id!=?", [0]);
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


    private function colorize(string $string): String
    {
        $translator = [
            "\033[39m" => "<span class='t-light'>",
            "\033[34m" => "<span class='t-info'>",
            "\033[32m" => "<span class='t-success'>",
            "[1;32;40m" => "<span class='t-create t-bold'>",
            "\033[91m" => "<span class='t-error'>",
            "[0m" => "</span>",
        ];

        return strtr($string, $translator);
    }
}