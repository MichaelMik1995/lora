<?php
namespace App\Core\View;
use App\Middleware\Auth;
use App\Core\Lib\Utils\ArrayUtils;
use \ReflectionClass;


class Template 
{
    public $token;
    protected $blocks = array();
    protected $cache_path = './temp/cache/';
    protected $cache_enabled = true;
    protected $ext = "lo.php";
    protected $temp_ext = "template";
    
    protected $auth;
    protected $array_utils;
    
    
    public function __construct(Auth $auth, ArrayUtils $array_utils) 
    {
        $this->token = '<input hidden type="text" name="token" value="'.@$_SESSION['token'].'"> '
                . '<input hidden type="text" name="SID" value="'.@$_SESSION['SID'].'">';
        $this->auth = $auth;
        $this->array_utils = $array_utils;
    }

    public function view(string $file="", string $module = "")
    {
        //get content
        $file_content = file_get_contents($file);

        //$get_filename = str_replace(["./resources/views/","/",$this->ext], ["","_",""], $file);
        $get_filename = str_replace([".","/"], "_", $file);

        $cached_file = $this->cache_path.$get_filename.".php";
        //put content

        $file_content = $this->compileView($file_content, $module);

        //Meanwhile cache content
        $file_new = fopen($cached_file, "w+");
        file_put_contents($cached_file, $file_content);
        fclose($file_new);

        //return path of cached file

       

        return $cached_file;
    }

    public function compileView(string $code, $module, bool $is_include = false)
    {
        $file_content = $this->compilePluginHtml($code);
        $file_content = $this->compileEscapedEchos($file_content);
        $file_content = $this->compileEchos($file_content);
        $file_content = $this->compilePHP($file_content);
        $file_content = $this->compileCsrfGen($file_content);
        $file_content = $this->compileRequestMethod($file_content);
        $file_content = $this->compileData($file_content);
        $file_content = $this->compileInclude($file_content);
        if($is_include === false)
        {
            $file_content = $this->compileModInclude($file_content, $module);
        }
        $file_content = $this->compiletemplateInclude($file_content);
        $file_content = $this->compileAuthBeginIf($file_content);
        $file_content = $this->compileAuthBegin($file_content);
        $file_content = $this->compileLogged($file_content);
        $file_content = $this->compileGuest($file_content);
        $file_content = $this->compileForeach($file_content);
        $file_content = $this->compileIf($file_content);
        $file_content = $this->compileFor($file_content);
        $file_content = $this->compileEndFor($file_content);
        $file_content = $this->compileBackButton($file_content);
        $file_content = $this->compileElseIf($file_content);
        $file_content = $this->compileEnds($file_content);
        $file_content = $this->compileMember($file_content);
        $file_content = $this->compileComment($file_content);

        return $file_content;
    }

    private function compilePHP($code) 
    {
        return preg_replace('~\@php\s*(.+?)\s*\@~is', '<?php $1 ?>', $code);
    }
    
    private function compileComment($code) {
            return preg_replace('~\@cmt\s*(.+?)\s*\@~is', '<!-- $1 -->', $code);
    }

    private function compileForeach($code) {
            return preg_replace('~\@foreach \s*(.+?)\s*\ @~is', '<?php foreach($1) : ?>', $code);
    }

    private function compileIf($code) 
    {
            return preg_replace('~\@if \s*(.+?)\s*\ @~is', '<?php if($1) : ?>', $code);
    }
    
    private function compileFor($code)
    {
            return preg_replace('~\@for \s*(.+?)\s*\ @~is', '<?php for($1) { ?>', $code);
    }
    
    private function compileEndFor($code)
    {
        return str_replace("@endfor @", "<?php } ?>", $code);
    }
    
    private function compileElseIf($code) 
    {
            return preg_replace('~\@elseif \s*(.+?)\s*\ @~is', '<?php elseif($1) : ?>', $code);
    }
    
    private function compileSubView($code, $view_sub="")
    {
        $cached = $this->view($view_sub);
        
        echo $cached;
        //$view_sub
        /*if($cached != "")
        { 
           return str_replace("@VIEW@ ", "<?php require_once('$cached') ?>", $code);
        }*/
    }


    private function compileEnds($code) 
    {
        $template = [
            "@endif",
            "@else",
            "@endforeach",
            "@endauth",
            "@endphp",
            "@js",
            "@endjs",
        ];

        $php = [
            "<?php endif; ?>",
            "<?php else : ?>",
            "<?php endforeach; ?>",
            "<?php endif; ?>",
            "?>",
            "<script type='text/javascript'>",
            "</script>"
        ];


        return str_replace($template, $php, $code);
    }

    private function compileEchos($code) {
            return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
    }

    private function compileAuthBegin($code) 
    {   
        $roles = "'".implode("','", $this->auth->role)."'";
        
        return preg_replace('~\@auth \s*(.+?)\s*\@~is', "<?php if(in_array(\"$1\", [$roles])) : ?>", $code);
    }
    
    private function compileAuthBeginIf($code) 
    {   
        $roles = "'".implode("','", $this->auth->role)."'";
        
        return preg_replace('~\@@auth \s*(.+?)\s*\@@~is', "in_array(\"$1\", [$roles])", $code);
    }
    
    private function compileLogged($code)
    {
        $is_logged = $this->auth->is_logged;
        
        return str_replace("@iflogged", "<?php if('$is_logged' == '1') : ?>", $code);
    }
    
    private function compileGuest($code)
    {
        $is_logged = $this->auth->is_logged;
        
        return str_replace("@ifguest", "<?php if('$is_logged' != '1') : ?>", $code);
    }
           
    private function compileInclude($code) 
    {
        return preg_replace('~\@include\s*(.+?)\s*\@~is', "<?php include('./resources/views/$1.".$this->ext."'); echo '<br>'; ?>", $code);
    }

    private function compileModInclude($code, $module) 
    {
        $finder = preg_match_all('/@modinclude(.*?)@/', $code, $match);
        if($finder)
        {
            //Foreach count($match)


            $string_finded = $match[1][0];
            $trim_space = str_replace(" ", "", $string_finded);
            $explode = explode(",", $trim_space);

            $file = "./App/Modules/".ucfirst($explode[1])."Module/resources/views/".$explode[0].".".$this->ext;
            $file_content = file_get_contents($file);
            preg_replace('~\@modinclude\s*(.+?)\s*\@~is', " ", $code);

            //replace @modinclude to $this->compileView() and .=
            return $code.$this->compileView($file_content, $module, true);
        }
        else
        {
            return $code;
        }
    }
    
    private function compiletemplateInclude($code) 
    {
        return preg_replace('~\@template\s*(.+?)\s*\@~is', "<?php include('./plugins/lora/lightsocket/templates/$1.".$this->temp_ext."'); echo '<br>'; ?>", $code);
    }

    
    private function compilePluginHtml($code) 
    {
            return preg_replace('~\@pluginload\s*(.+?)\s*\@~is', "<?php include('./plugins/$1/html_loader/index.phtml'); ?>", $code);
    }

    private function compileEscapedEchos($code) {
            return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

    private function compileCsrfGen($code)
    {
        return str_replace("@csrfgen", $this->token, $code);
    }

    private function compileRequestMethod($code) 
    {
        return preg_replace('~\@request\(\s*(.+?)\s*\)~is', "<input hidden type='text' name='method' value='$1'>", $code);
    }

    private function compileData($code) 
    {
        return preg_replace('~\@data\(\s*(.+?)\s*\)~is', "<input hidden type='text' name='data' value='{{ http_query_builder($1) }}'>", $code);
    }
    
    private function compileMember($code)
    {        
        return str_replace(["@username", "@useruid", "@userid"], [$this->auth->user_name, $this->auth->user_uid, $this->auth->user_raw_id], $code);
    }
    
    private function compileBackButton($code)
    {
        return preg_replace('~\@backbutton \s*(.+?)\s*\@~is', "<button type='button' onClick='window.history.back()' class='button-small $1'><i class='fa fa-chevron-left'></i> Zpět</button>", $code);
    }

}
?>