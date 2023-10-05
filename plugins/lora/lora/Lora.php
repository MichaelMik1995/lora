<?php
declare(strict_types=1);

namespace Lora\Lora;

use Lora\Lora\Core\LoraOutput;

/**
 * MAIN CLI Class Lora for executing native commands
 */
class Lora
{
    private string $json_cmds_register = __DIR__."/core/cmd_register.json";

    public function __construct() {}
    
    /**
     * Input Flow from Lora CLI
     * 
     * @param string $command_line      Imploded command line ARGV
     * @return void
     */
    public function prepareCommand(string $command_line)
    {
        $explode_command = explode(" ", $command_line);
        $command = @$explode_command[1];
        $argument = @$explode_command[2];

        $options = array_splice($explode_command, 3);   
        
        if(in_array("--debug", $options) || $argument == "--debug" || $command == "--debug")
        {
           $this->callDebug($command, $argument, $options);
        }
        else
        {
            $this->callCommander($command, $argument, $options);
        }
    }

    /**
     * Calling commander via command
     * 
     * @param string $command       Command ARGV[1];            example: dbtable:create
     * @param string $argument      Argument ARGV[2];           example: my-table
     * @param array $options        Options [ ARGV[3...] ];     example: --caller --data
     */
    private function callCommander(string $command, string $argumemt, array $options)
    {
        //echo "DEBUG: COMMAND: $command | ARG: $argumemt | OPTIONS: ".var_dump($options)."\n\n";
        if($command != null)
        {
            $json_content = file_get_contents($this->json_cmds_register);
            $commander_array = json_decode($json_content, flags:JSON_OBJECT_AS_ARRAY);

            foreach($commander_array as $commander => $cmds)
            {
                $cmd = implode(",", str_replace(" ", "", $cmds));
                if(str_contains($cmd, $command))
                {
                    //If command is in cmds for $commander -> call this commander for execute
                    $static_class = "Lora\Lora\Core\Commander\\".$commander."Commander";
                    $static_class::instance()->SendCommand($command, $argumemt, $options);
                }
            }
        }
        else
        {
            //print '### usage: php fram [$command] [$arguments = []]';
            LoraOutput::output('Usage: php lora [$command] [$argumemts = [] ]', "error");
            LoraOutput::output('Usage: php lora [help, -h]', "warning");
            exit();
        }
    }

    /**
     * 
     */
    private function callDebug(string $command, string $argumemt, array $options)
    {
        $implode_options = implode(", ", $options);
        LoraOutput::output("CMD DEBUG: COMMAND: $command | ARGument: $argumemt | OPTIONS: $implode_options");
    }
}
?>
