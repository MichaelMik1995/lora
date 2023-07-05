<?php 
declare(strict_types=1);

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
            return 1;
        }
        else
        {
            return $trimm;
        }
        
    }
    else
    {
        echo "Unknown environment parameter";
        return 1;
    }
}


function lang(string $language_parameter, $echo = true)
{
    if($echo === true)
    {
        echo call_user_func_array('\App\Core\Lib\Language::lang', [$language_parameter]);
    }
    else
    {
        return call_user_func_array('\App\Core\Lib\Language::lang', [$language_parameter]);
    }
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