<?php 
    session_start(); 
    $_SESSION["restrict_images"] = false; 
    
    $get_config = parse_ini_file("../../../../config/web.ini");
    $session_store = $get_config["WEB_SESSION_STORE_NAME"];

    $user = $_SESSION[$session_store]["uid"]; 
?>
<div class="easyText-Dialog_inner pd-2" style="max-width: 800px;">

    <div class="content-center">
    
        Vložit URL obrázku:
        <input id="image_url" type="text" placeholder="https://" class="input-dark width-50 width-100-xsm">
        <button class="button button-easytext" id="url_img_toArea">Vložit</button><br><br>
        <span style="font-size: 10px; ">* Na obrázky se mohou vztahovat autorská práva. Za sdílení obrázků neneseme žádnou odpovědnost.</span>
    </div>

    <?php if(isset($_SESSION["restrict_images"]) && $_SESSION["restrict_images"] === false) : ?>
    <div id="image_choose_gallery" class="es_block" style="overflow: auto;">
        <a title="Nahrajte obrázek/obrázky k vložení do příspěvku/komentáře" class="t-bold t-light t-warning-hover" href="/user/gallery">
            <i class="fa fa-plus-circle"></i> Nový obrázek
        </a>
        <div class="background-dark-2 pd-1 pd-md-2 bd-round-3 height-512p height-1024p-xsm" style="margin-top: 10px; overflow: auto;">
        <?php $file = "../../../../App/Modules/UserModule/public/img/author/$user/images/thumb"; ?>

            <div class="mgy-1 row cols-auto">
                <?php foreach(glob("$file/*") as $thumb) : ?>
                    <?php 
                    $img = str_replace("/thumb", "", $thumb);
                    $imageTitle = str_replace("$file/", "", $thumb);
                    if($img!=$file) : 
                    ?>
                        <div class="column-shrink pd-1">
                            <div>
                                <img id="<?= $img ?>" src="<?= $thumb ?>" class="bd-round-3 transparent-hover-50" title="Vybrat: <?= $imageTitle ?>" height="96">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
    //define var user for easyText.js
    var user = '<?= $user ?>';
</script>
