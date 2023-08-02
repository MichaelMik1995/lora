<?php
/*
    Plugin EText generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\EText;

use App\Core\Interface\InstanceInterface;

class EText implements InstanceInterface
{

    private static $_instance;
    private static $_instance_id;

    private $json_file;

    public static function instance()
    {
        if(self::$_instance == null)
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

    public function compile(string $content)
    {
        
        if(!isset($this->json_file))
        {
            $this->json_file = json_decode(file_get_contents(__DIR__. "/src/config/replacement.json"), true);
        }

        $replaced_text = $content;

        $json = $this->json_file;
        $blocks_to_tags = $json['blocks_to_tags'];


        foreach ($blocks_to_tags as $pattern) {
            $block = $pattern['block'];
            $tag = $pattern['tag'];

            $text = preg_replace($block, $tag, $replaced_text);
        }

        return $replaced_text;


    }
}
