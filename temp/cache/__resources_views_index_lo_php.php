<!<!doctype html>
<html lang="cz-cs">
    <head>
    <title><?php echo $page_title ?> | <?php echo $WEB_TITLE ?></title>
        <base href="<?php echo $WEB_ADDRESS ?>/">
        <link rel="icon" type="image/png" href="<?php echo asset('img/favicon/favicon.png') ?>">
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width; initial-scale=1.0;">
        <meta name="description" content="<?php echo env('web_description') ?>">
        <meta name="theme-color" content="#1a1a1a"/>
 
        <!-- BEGIN loading Stylesheets -->
        <?php foreach(glob("./public/css/*.css") as $style) : ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $style ?>">
        <?php endforeach; ?>

        <link type="text/css" rel="stylesheet" href="<?php echo asset('css/style.css') ?>">

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
                        <img src="<?php echo asset('img/logo/main_logo.jpeg') ?>" class="height-40p" alt="main lora logo">
                        <span redirect="/" class="t-warning header-3 header-4-xsm cursor-point">LORA</span> <span class="display-0-xsm">| Rychlý a bezpečný web</span>
                    </div>

                    <!-- Brand | TEMPLATE -> second column -->
                    <div id="layout-second-column" class="column-3 column-6-xsm pdx-2 pdy-2-xsm">
                        <div class="content-right">
                            <span class="display-xsm display-sm display-md display-lrg display-xlrg"></span>
                        <?php if('1' == '1') : ?>
                            <button redirect="user" class="button-circle width-32p height-32p button-warning">
                                <i class="fa fa-user"></i>
                            </button>  
                            <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
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
