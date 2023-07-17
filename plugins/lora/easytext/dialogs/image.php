<?php 
    session_start(); 
    $_SESSION["restrict_images"] = false; 
 
    $storage_key = $_SESSION["session_storage_key"];
    $session_data_container = $_SESSION[$storage_key];

    $user = $session_data_container["uid"];
    $hashed_uid = $session_data_container["hashed_uid"]; 

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
        <a title="Nahrajte obrázek/obrázky k vložení do příspěvku/komentáře" class="t-bold t-light t-warning-hover" href="/user/app/gallery">
            <i class="fa fa-plus-circle"></i> Nový obrázek
        </a>
        <div class="background-dark-2 pd-1 pd-md-2 bd-round-3 height-512p height-1024p-xsm" style="margin-top: 10px; overflow: auto;">
        <?php $folder = "../../../../content/uploads/$hashed_uid/images/thumb"; ?>

            <div class="header-4 t-info t-bold pdy-2">Moje obrázky: </div>
            <div class="mgy-1 row cols-auto">
                <?php if(isset($hashed_uid)) : ?>
                    <?php foreach(glob("$folder/*") as $thumb) : ?>
                        <?php 
                        $img = str_replace("/thumb", "", $thumb);
                        $imageTitle = str_replace("$folder/", "", $thumb);
                        ?>
                            <div class="column-shrink pd-1">
                                <div>
                                    <img id="<?= $img ?>" src="<?= $thumb ?>" class="bd-round-3 transparent-hover-50" title="Vybrat: <?= $imageTitle ?>" height="96">
                                </div>
                            </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <hr>
            <div class="header-4 t-info t-bold pdy-2">Veřejné obrázky: </div>
            <div class="mgy-1 row cols-auto">
                <?php foreach(glob("../../../../public/upload/images/thumb/*") as $thumb) : ?>
                    <?php 
                    $img = str_replace("/thumb", "", $thumb);
                    $imageTitle = str_replace("$folder/", "", $thumb);
                    ?>
                        <div class="column-shrink pd-1">
                            <div>
                                <img alt="<?= $img ?>" id="<?= $img ?>" src="<?= $thumb ?>" class="bd-round-3 transparent-hover-50" title="Vybrat: <?= $imageTitle ?>" height="96">
                            </div>
                        </div>
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
