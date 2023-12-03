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

        <!-- FONT Awesome FREE -->
            @foreach glob("./public/font_awesome/".env("font_awesome",false)."/css/*.css") as $fa_css @
                <link rel="stylesheet" href="{{ $fa_css }}">
            @endforeach

        
            
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
        <script src="{{asset('js/jquery/jquery_3_7_0.js')}}"></script>
        <script src="{{asset('js/jquery/jquery-ui/jquery-ui.js')}}"></script>

        @pluginload lora/etext @
        
        @foreach glob("./public/js/lib/autoload/*.js") as $autoload_js @
        <script src="{{$autoload_js}}" type="text/javascript"></script>
        @endforeach

        @pluginload lora/easytext @ <!-- Load HTML for plugin in ./plugins/lora/easytext/html_loader/index.phtml -->
        
        @pluginload lora/gengine @

        <!-- <script src="https://kit.fontawesome.com/0b54168b2a.js" crossorigin="anonymous"></script>-->
        

        <!-- END Javascripts -->
    </head>
    
    <body class="t-dark">
        
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
        
        <div class="bgr-dark-2 pdy-1 pdx-3">
            <div class="row">
                <div class="column-2">

<<<<<<< HEAD
                    <!-- Main Logo Image -->
                    <img rel="easySlider" src="{{asset('img/logo/logo.jpg')}}" class="width-32p height-32px bd-round-circle" alt="main web logo">
                </div>
                <div class="column-8 content-right">
                    <span class="display-xsm display-sm display-md display-lrg display-xlrg"></span>
                    <button redirect="/" class="button-circle width-32p height-32p button-dark">
                        <i class="fa fa-home"></i>
                    </button>  
                    @iflogged
                        <button redirect="user" class="button-circle width-32p height-32p button-dark">
                            <i class="fa fa-user"></i>
                        </button>  
                        @auth admin @
                            @if $WEB_STATUS == "DEVELOP" || $WEB_STATUS == "DEBUG" @
                                <button redirect="admindev" class="button-circle width-32p height-32p button-dark">
                                    <i class="fa fa-terminal"></i>
=======
                    <!-- Brand | TEMPLATE -> first column -->
                    <div id="layout-first-column" class="column-7 column-4-xsm">
                        <img src="{{asset('img/logo/main_logo.jpeg')}}" class="height-40p" alt="main lora logo">
                        <span redirect="/" class="t-warning header-3 header-4-xsm cursor-point">{{ $WEB_NAME }}</span> <span class="display-0-xsm">| {{ $WEB_DESCRIPTION }}</span>
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
>>>>>>> 32f08c4d693ad1b5bc522c9a6ed41cc95ab83cf9
                                </button>  
                            @endif
                            <button redirect="admin" class="button-circle width-32p height-32p button-dark">
                                <i class="fa fa-cog"></i>
                            </button>  
                        @endauth
                        <button redirect="auth/logout" class="button-circle width-32p height-32p button-dark">
                            <i class="fa fa-close"></i>
                        </button>  
                    @else
                        <button redirect="auth/login" class="button-circle width-32p height-32p button-dark">
                            <i class="fa fa-user"></i>
                        </button>  
                    @endif
                </div>
            </div>
        </div>
         <!-- Navigation-->
        <nav class="pdy-2 pdx-3 bd-bottom-dark-2 bgr-light">
            <div class="row">
                <div class="column-4 column-5-xsm">
                    <div class="pd-1">

                        <!-- Web Name -->
                        <div class="t-dark content-center-xsm content-center-sm"><span redirect="/" class="t-primary-hover t-bolder cursor-point header-3 header-4-xsm">{{ $WEB_NAME }}</span> <span class="display-0-xsm">| {{ $WEB_DESCRIPTION }}</div>
                    </div>
                </div>
                <div class="column-5-xsm display-0 display-1-xsm display-1-sm content-right">
                    <button event-toggle-class="click:fa-times:fa-bars:#menu-bar-toggler" onClick="$('#mobile-navigation-toggle').slideToggle(200)" class="button button-circle width-40p height-40p button-bd-dark content-center"><i id="menu-bar-toggler" class="fa fa-bars header-2"></i></button>
                </div>
                <div class="column-6 column-10-xsm">

                    <!-- Link template -->
                    <div template=1 id="navigation-link"><div class="column pdy-2 pdx-5 content-center-xsm content-center-sm anim-all-normal scale-11-hover "><a href="/{link}" class="t-dark t-primary-hover header-6 header-5-sm "><i class="{icon} mgx-1"></i>{name}</a></div></div>
                        
                    <!-- Navigation links -->
                    <div id="mobile-navigation-toggle" class="display-1-md display-1-lrg display-1-xlrg display-0-xsm display-0-sm">
                        <div  class="row cols-auto cols-1-xsm cols-2-sm">
                            <div copy-element="navigation-link" data="link:bezbl/app/news,icon:fa fa-newspaper,name:Novinky"></div>
                            <div copy-element="navigation-link" data="link:#,icon:fa fa-paw,name:Naši svěřenci"></div>
                            <div copy-element="navigation-link" data="link:#,icon:fa fa-images,name:Galerie"></div>
                            <div copy-element="navigation-link" data="link:#,icon:fa fa-envelope,name:Kontakt"></div>
                        </div>
                    </div>   
                </div>
            </div>
           
        </nav>
        
        <main class="" style="padding-bottom: 5em;">
            {{$controll->loadView()}}
        </main>
        
        <footer class="display-1 bottom-fixed background-dark-2 bd-2 bd-top-dark width-100 pd-2">
         <span class="t-primary">Bezblešek, z.s</span> - Tento web byl vytvořen pomocí frameworku <span title="LORA je nyní ve verzi V32B2 - pokud najdete chybu, napište mi prosím na email: miroji@email.cz" class="t-primary">LORA</span> 2022 - 2023 by <a href="https://miroji.eu" target="_blank" class="t-primary t-warning-hover">@MiroJi</a>
        </footer>
        
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
