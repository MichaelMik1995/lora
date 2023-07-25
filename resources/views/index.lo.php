<!DOCTYPE html>
<html lang="cs">
    <head>
        <title>{{ $page_title }} | {{ $WEB_TITLE }}</title>
        <base href="{{$WEB_ADDRESS}}/">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon.png') }}">
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width; initial-scale=1.0;">
        <meta name="description" content="{{ env('web_description') }}">
        <meta name="theme-color" content="#1a1a1a"/>
 
        <!-- BEGIN loading Stylesheets -->
        @foreach glob("./public/css/*.css") as $style @
        <link type="text/css" rel="stylesheet" href="{{$style}}">
        @endforeach

        <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">

        @if !empty($css) @
            @foreach $css as $st @
                @foreach glob("./App/Modules/".ucfirst($st)."Module/public/css/*.css") as $mod_css @
                    <link rel="stylesheet" href="{{ $mod_css }}">
                @endforeach
            @endforeach
        @endif

        
            
        <!-- END stylesheets -->
        
        
        <!-- BEGIN loading Javascripts  -->
        
        @if isset($_SESSION["token"]) @
        <script>
            localStorage.setItem('TOKEN', '{{$_SESSION["token"]}}');
            localStorage.setItem('SID', '{{$_SESSION["SID"]}}');
        </script>
        @endif
        <script>
            localStorage.setItem('DOMAIN', '{{$_SESSION["SID"]}}');
        </script>

        <script src="./lang/{{$LANGUAGE}}/stylize_lang.js"></script>
        <script src="{{asset('js/jquery/jquery.js')}}"></script>
        <script src="{{asset('js/jquery/jquery-ui/jquery-ui.js')}}"></script>

        @foreach glob("./public/js/lib/autoload/*.js") as $autoload_js @
        <script src="{{$autoload_js}}" type="text/javascript"></script>
        @endforeach

        @pluginload lora/easytext @ <!-- Load HTML for plugin in ./plugins/lora/easytext/html_loader/index.phtml -->
        @pluginload lora/etext @

        <script src="https://kit.fontawesome.com/0b54168b2a.js" crossorigin="anonymous"></script>
        

        <!-- END Javascripts -->
    </head>
    
    <body>
        
        <div class='easyText-Dialog_block bd-3 bd-dark-3' id='dialogDiv'>
            <div title='Podržením přesunout' id='dialog-handle' class='background-dark-2 content-right pd-1'>
                <button id='easyText-close' class='button button-error'><i class="fa fa-times-circle"></i></button>
            </div>
            <div class="easyText-Dialog padd-1 overflow-hidden"></div>
        </div>

        <div class="content-center width-75 width-100-sm mg-auto">
            @foreach $lora_messages as $lora_message @
            <div title="Kliknutím zavřít zprávu" onClick="$(this).hide(500).delay(600).remove()" class="top-fixed top-5 button-small button-error width-75 width-100-sm pd-1 lora_message"><i class="fa fa-exclamation-triangle" style="margin-right: 1em;"></i> <b>{{{$lora_message}}}</b></div>
            @endforeach
            
            @foreach $lora_messages_true as $lora_message_true @
            <div title="Kliknutím zavřít zprávu" onClick="$(this).hide(500).delay(600).remove()" class="top-fixed top-5 button-small button-create width-75 width-100-sm pd-1 lora_message_success"><i class="fa fa-check-circle" style="margin-right: 1em;"></i> <b>{{{$lora_message_true}}}</b></div>
            @endforeach
        </div> 
        
        
         <!-- Navigation-->
        <nav class=" nav-primary pd-2">
            <!-- Main LORA Brand -->
            <div class="pd-1">
                <div class="row">

                    <!-- Brand | TEMPLATE -> first column -->
                    <div id="layout-first-column" class="column-7 column-4-xsm">
                        <img src="{{asset('img/logo/main_logo.jpeg')}}" class="height-40p" alt="main lora logo">
                        <span redirect="/" class="t-warning header-3 header-4-xsm cursor-point">LORA</span> <span class="display-0-xsm">| Rychlý a bezpečný web</span>
                    </div>

                    <!-- Brand | TEMPLATE -> second column -->
                    <div id="layout-second-column" class="column-3 column-6-xsm pdx-2 pdy-2-xsm">
                        <div class="content-right">
                            <span class="display-xsm display-sm display-md display-lrg display-xlrg"></span>
                        @iflogged
                            <button redirect="user" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-user"></i>
                            </button>  
                            @auth admin @
                                @if $WEB_STATUS == "DEVELOP" || $WEB_STATUS == "DEBUG" @
                                    <button redirect="admindev" class="button-circle width-32p height-32p button-warning">
                                        <i class="fa fa-terminal"></i>
                                    </button>  
                                @endif
                                <button redirect="admin" class="button-circle width-32p height-32p button-warning">
                                    <i class="fa fa-cog"></i>
                                </button>  
                            @endauth
                            <button redirect="auth/logout" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-close"></i>
                            </button>  
                        @else
                            <button redirect="auth/login" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-user"></i>
                            </button>  
                        @endif
                        </div>
                    </div>
                </div>
            </div>

           
        </nav>
        
        <div class="">
            <div class="">
                {{$controll->loadView()}}
            </div>
        </div>
        
        <div class="display-0 bottom-fixed background-dark-2 bd-2 bd-top-dark width-100 pd-2">
            Tato webová stránka je prezentací frameworku Lora verze 2.0
        </div>
        
    </body>

    <script>
    function highlightSyntax() {
      var codeBlock = $('.eTcode'); //.getElementById('#eTcode');
      var code = codeBlock.text();

      var highlightedCode = code
        .replace(/class|function/g, '<span style="color: aqua;">$&</span>')
        .replace(/const|let|var/g, '<span class="variable">$&</span>');

        console.log(highlightedCode);
      codeBlock.html(highlightedCode);
    }

    // Zavolej funkci po načtení stránky pro provedení zvýraznění syntaxe
    window.onload = highlightSyntax;
  </script>
</html>
