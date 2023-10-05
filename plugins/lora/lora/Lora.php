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
    
    public function prepareCommand(string $command_line)
    {
        $explode_command = explode(" ", $command_line);
        $command = @$explode_command[1];
        $argument = @$explode_command[2];

        $options = array_splice($explode_command, 3);   
        
        $this->callCommander($command, $argument, $options);
    }

    private function switchCommander(string|null $command, string|null $argument, array $options = [])
    {

        if($command != null)
        {
        }
        else
        {
            LoraOutput::output('Usage: php lora [$command] [$argumemts = [] ]', "error");
            LoraOutput::output('Usage: php lora [help, -h]', "warning");
            exit();
        }
        
    }

    /**
     * Calling commander via command
     * 
     * @param string $command
     * @param string $argument
     * @param array $options
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
}
?>
