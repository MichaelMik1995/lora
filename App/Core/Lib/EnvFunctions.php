<?php 
declare(strict_types=1);

use App\Core\Lib\Utils\VariableUtils;

function asset(string $path)
{
    echo call_user_func_array('\App\Core\Lib\Asset::asset', [$path]);
}

function modasset(string $path, string $module = "" )
{
    echo call_user_func_array('\App\Core\Lib\Asset::modulePath', [$path, $module]);
}

function redirect(string $url, int $request = 0)
{
    echo call_user_func_array('\App\Core\Application\Route::route', [$url, $request]); 
}

function url(string $url, int $request = 0)
{
    echo 'onClick="document.location=\''.$url.'\'"';
}

function route(string $route, array $data = [])
{
    $route_replace = str_replace(".","_", $route);
    $http_query = http_build_query($data);
    $encode_data = base64_encode($http_query);
    echo "/route/".$route_replace."/".$encode_data;
}


function var_dumper(mixed $input, string $dumpname="", bool $extended = true, int $width = 3)
{
    $var_instance = VariableUtils::instance();

    echo call_user_func_array([$var_instance, 'varDumper'], [$input, $dumpname, $extended, $width, 0]);
}

/*function drawpage(string $page)
{
    return call_user_func_array('\App\Core\Pagembler\Assembler::preparePage', [$page]); 
}*/


function env(string $environment_parameter, $echo = true)
{
    if(isset($_ENV[$environment_parameter]))
    {
        $trimm = trim($_ENV[$environment_parameter], '"');
        if($echo === true)
        {
            echo $trimm;
        }
        else
        {
            return $trimm;
        }
        
    }
    else
    {
        echo "Unknown environment parameter: ".$environment_parameter;
        return 1;
    }
}


/**
 * Get translated string
 *
 * @param string $language_parameter
 * @param boolean $echo
 * @return string
 */
function lang(string $language_parameter, $echo = true): string
{
    if($echo === true)
    {
        echo call_user_func_array('\App\Core\Lib\Language::lang', [$language_parameter]);
        return "";
    }
    else
    {
        return call_user_func_array('\App\Core\Lib\Language::lang', [$language_parameter]);
    }
}

/**
 * Paint icon
 *
 * @param string $icon_name
 * @param string|int $icon_width
 * @return void
 */
function icon(string $icon_name, $color="dark", string|int $icon_width = "32")
{
    echo "<img src=\"public/img/icon/base/$color/$icon_name.svg\" alt=\"$icon_name\" width=\"$icon_width\">";
}

function image(string $path, string $module)
{
    echo call_user_func_array('\App\Core\Lib\Asset::image', [$path, $module]);
}

/**
 * @param string|int $author_id
 * @param bool $echo
 * @return void|callable
 */
function author(string|int $author_id, $echo = true)
{
    if($echo === true)
    {
        echo call_user_func_array('\App\Core\Lib\Author::author', [$author_id]);
    }
    else
    {
        return call_user_func_array('\App\Core\Lib\Author::author', [$author_id]);
    }
}

function real_filesize(string|int $real_size, $echo = true)
{
    if($echo === true)
    {
        echo call_user_func_array("\App\Core\Lib\Utils\FileUtils::getRealFileSize", [$real_size]);
    }
    else
    {
        return call_user_func_array("\App\Core\Lib\Utils\FileUtils::getRealFileSize", [$real_size]);
    }

}

function is_empty(string|null $string, $empty_information = "")
{
    if(empty($string))
    {
        echo $empty_information;
    }
    else
    {
        echo $string;
    }
}

function real_date(string|null $date = "", string $format = "d.m.Y H:i:s")
{
    if(!empty($date))
    {
        echo DATE($format, intval($date));
    }
    else
    {
        echo DATE($format, time());
    }
}