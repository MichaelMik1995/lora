<!<!doctype html>
<html lang="cz-cs">
    <head>
    <title><?php echo $page_title ?> | <?php echo $WEB_TITLE ?></title>
        <base href="<?php echo $WEB_ADDRESS ?>/">
        <link rel="icon" type="image/png" href="<?php echo asset("img/favicon/favicon.png") ?>">
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width; initial-scale=1.0;">
 
        <!-- BEGIN loading Stylesheets -->
        <?php foreach(glob("./public/css/*.css") as $style) : ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $style ?>">
        <?php endforeach; ?>

        <link type="text/css" rel="stylesheet" href="<?php echo asset("css/style.css") ?>">

        <?php if(!empty($css)) : ?>
            <?php foreach($css as $st) : ?>
                <?php foreach(glob("./App/Modules/".ucfirst($st)."Module/public/css/*.css") as $mod_css) : ?>
                    <link rel="stylesheet" href="<?php echo $mod_css ?>">
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>

            
        <!-- END stylesheets -->
        
        
        <!-- BEGIN loading Javascripts  -->
        
        <?php if(isset($_SESSION["token"])) : ?>
        <script>
            localStorage.setItem('TOKEN', '<?php echo $_SESSION["token"] ?>');
            localStorage.setItem('SID', '<?php echo $_SESSION["SID"] ?>');
        </script>
        <?php endif; ?>
        <script>
            localStorage.setItem('DOMAIN', '<?php echo $_SESSION["SID"] ?>');
        </script>

        <script src="./lang/<?php echo $LANGUAGE ?>/stylize_lang.js"></script>
        <script src="<?php echo asset('js/jquery/jquery.js') ?>"></script>
        <script src="<?php echo asset('js/jquery/jquery-ui/jquery-ui.js') ?>"></script>

        <?php foreach(glob("./public/js/lib/autoload/*.js") as $autoload_js) : ?>
        <script src="<?php echo $autoload_js ?>" type="text/javascript"></script>
        <?php endforeach; ?>

        <?php include('./plugins/lora/easytext/html_loader/index.phtml'); ?> <!-- Load HTML for plugin in ./plugins/lora/easytext/html_loader/index.phtml -->

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
            <?php foreach($lora_messages as $lora_message) : ?>
            <div title="Kliknutím zavřít zprávu" onClick="$(this).hide(500).delay(600).remove()" class="top-fixed top-5 button-small button-error width-75 width-100-sm pd-1 lora_message"><i class="fa fa-exclamation-triangle" style="margin-right: 1em;"></i> <b><?php echo htmlentities($lora_message, ENT_QUOTES, 'UTF-8') ?></b></div>
            <?php endforeach; ?>
            
            <?php foreach($lora_messages_true as $lora_message_true) : ?>
            <div title="Kliknutím zavřít zprávu" onClick="$(this).hide(500).delay(600).remove()" class="top-fixed top-5 button-small button-create width-75 width-100-sm pd-1 lora_message_success"><i class="fa fa-check-circle" style="margin-right: 1em;"></i> <b><?php echo htmlentities($lora_message_true, ENT_QUOTES, 'UTF-8') ?></b></div>
            <?php endforeach; ?>
        </div> 
        
        
         <!-- Navigation-->
        <nav class=" nav-primary pd-2">
            <!-- Main LORA Brand -->
            <div class="pd-1">
                <div class="row">

                    <!-- Brand | TEMPLATE -> first column -->
                    <div id="layout-first-column" class="column-7 column-4-xsm">
                        <img src="<?php echo asset('img/logo/main_logo.jpeg') ?>" class="height-40p">
                        <span redirect="" class="t-warning header-3 header-4-xsm cursor-point">LORA</span> <span class="display-0-xsm">| Rychlý a bezpečný web</span>
                    </div>

                    <!-- Brand | TEMPLATE -> second column -->
                    <div id="layout-second-column" class="column-3 column-6-xsm pdx-2 pdy-2-xsm">
                        <div class="content-right">
                            <span class="display-xsm display-sm display-md display-lrg display-xlrg"></span>
                        <?php if('' == '1') : ?>
                            <button redirect="user" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-user"></i>
                            </button>  
                            <?php if(in_array("admin", [''])) : ?>
                                <?php if($WEB_STATUS == "DEVELOP" || $WEB_STATUS == "DEBUG") : ?>
                                    <button redirect="admindev" class="button-circle width-32p height-32p button-warning">
                                        <i class="fa fa-terminal"></i>
                                    </button>  
                                <?php endif; ?>
                                <button redirect="admin" class="button-circle width-32p height-32p button-warning">
                                    <i class="fa fa-cog"></i>
                                </button>  
                            <?php endif; ?>
                            <button redirect="auth/logout" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-close"></i>
                            </button>  
                        <?php else : ?>
                            <button redirect="auth/login" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-user"></i>
                            </button>  
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row Hrefs|Finder -->
            <div class="row pd-2 display-0">

                <!-- Hrefs -->
                <div copy-attr="layout-first-column:class">
                    <a href="" id="menu-href" class="header-6 mgx-2 t-light t-hover-warning cursor-point"><i class="fa-home"></i> Domů</a>
                    <a href="news" copy-attr="menu-href:class">Novinky</a>
                    <a href="forum" copy-attr="menu-href:class">Forum</a>
                    <a href="tutorial" copy-attr="menu-href:class">Návody</a>
                    <a copy-attr="menu-href:class" href="portfolio">Projekty</a>
                </div>

                <!-- Finder -->
                <div copy-attr="layout-second-column:class">
                    <form method="post">
                        <input hidden type="text" name="token" value="ab9b414fcf997e4a03fbcd5d2897c93b9950b6b0659571546bce82ee333cdc9c"> <input hidden type="text" name="SID" value="de9c0b8717be54905184b3f2134b72de">
                        <!-- @request post @ -->
                        <input type="search" name="search-string" class="bd-round-2 pd-1 header-6 width-100 background-light bd-1 bd solid bd-dark-3" placeholder="Vyhledat ...">
                    </form>
                </div>
            </div>
        </nav>

        <nav class="display-0 nav-primary background-dark-2 bd-bottom-dark2">
            <div class="row">
                <div class="column-2 column-10-xsm column-2-sm column-3-md"> <!-- BRAND -->
                    <div class="row pd-2">
                        <div class="column-2 column-10-xsm display-0-xsm">
                            <img class="bd-round-circle width-50 image-h-auto" src="<?php echo asset("img/logo/main_logo.jpeg") ?>">
                        </div>
                        <div class="column mg-auto">
                            
                            <img class="width-15-sm width-15-md bd-round-circle display-0 display-1-xsm" src="<?php echo asset("img/logo/main_logo.jpeg") ?>">
                            <div redirect="" class="header-6"><a class="t-light a-link t-hover-warning"><?php echo $WEB_TITLE ?></a></div>
                            <div class="subheader-5">
                                <i class="fa fa-eye"></i>
                                <?php if($page_title=="") : ?>
                                    <span><?php echo $WEB_TITLE ?></span>
                                <?php else : ?>
                                    <span><?php echo $page_title ?></span>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                        <div class="column pdy-1-sm header-2 content-right-sm display-0 display-1-xsm">
                            <i style='font-size: 30px;' onClick="$('.hide_navigation').slideToggle(200)" class="fa fa-bars"></i>
                        </div>
                    </div>  
                </div>

                <div class="column-10-xsm column pdy-4 content-center-sm hide_navigation display-0-xsm">
                   
                    <a id="menu-href" listen-url="homepage" url-valid="addClass:t-bolder" class="a-link t-light t-hover-warning mgx-2" href="/"><i class="fa fa-home"></i> Hlavní</a>
                    <a href="documentation" copy-attr="menu-href:class" listen-url="documentation" url-valid="addClass:t-bolder">Dokumentace</a>
                </div>

                <div class="column-10-xsm column-10-sm column-3 content-center-sm pdx-4-sm content-right hide_navigation display-0-xsm">
                    <?php if('' == '1') : ?>
                        <button class="mgy-3 button button-basic" onClick="redirect('user/profile')"><i class="fa fa-user"></i><span class='display-0-sm'> </span></button>           
                        <?php else : ?>
                        <button onClick="redirect('auth/login')" class="mgy-3 text-shadow-1 button button-basic"><i class="fa fa-user"></i> Přihlásit se</button>
                    <?php endif; ?>
                    
                    <?php if('' == '1') : ?>
                    <button class="button button-warning" onClick="redirect('auth/logout')"><i class="fa fa-sign-out-alt"></i><span class='display-0-sm'> Odhlásit se</span></button>
                    <?php endif; ?>
                    
                   
                </div>    
            </div>
        </nav>
        
        <div class="">
            <div class="">
                <?php echo $controll->loadView() ?>
            </div>
        </div>
        
        <div class="display-0 bottom-fixed background-dark-2 bd-2 bd-top-dark width-100 pd-2">
            Tato webová stránka je prezentací frameworku Lora verze 2.0
        </div>
        
    </body>
</html>
