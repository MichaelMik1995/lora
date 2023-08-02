<?php
declare (strict_types=1);

namespace Lora\Compiler;

/**
 * @author MiroJi <miroslav.jirgl@seznam.cz>
 */
trait Templator
{
    /**
     * 
     * @param string $content
     * @param array $compile_text
     * @return boolean|string
     */
    public static function compile(string $content, array $compile_text = []): String
    {
        if(!empty($compile_text))
        {
            $array_code = [];
            $array_vars = [];

            foreach($compile_text as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;
            }

            return str_replace($array_code, $array_vars, $content);
        }
        else
        {
            return $content;
        }
    }
}
