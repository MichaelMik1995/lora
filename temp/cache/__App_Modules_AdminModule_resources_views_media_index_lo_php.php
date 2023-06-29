<div class="content-center mgy-1">
    <form method="post" action="/admin/app/media-pictures-insert" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="538fb255d54af89e92b41f7ba41b2f0398771d0fb563701e146f7040854f618b"> <input hidden type="text" name="SID" value="315cd74ea61c616ae1f776cf144472c1">
        <input hidden type='text' name='method' value='get'>

        <input type="file" multiple name="images[]" class="input-dark pd-2">
        <button type="submit" class="button button-info"><i class="fa fa-plus-circle"></i> Přidat obrázek/ky</button>
    </form>
</div>

<hr>

<div class="row row-center-lrg row-center-xsm cols-auto cols-2-xsm">
    <?php foreach(glob("./App/Modules/AdminModule/resources/img/user/".$user_uid."/thumb/*") as $image) : ?>
        <?php $image_full_name = str_replace("./App/Modules/AdminModule/resources/img/user/".$user_uid."/thumb/", "", $image) ?>
        <?php $image_exploded = explode(".", $image_full_name); $image_name = $image_exploded[0]; $image_ext = $image_exploded[1] ?>
        
        <?php if(file_exists("./App/Modules/AdminModule/resources/img/user/".$user_uid."/$image_name.txt")) : ?>
            <?php $image_alt_text = $text_parser->parse("./App/Modules/AdminModule/resources/img/user/".$user_uid."/$image_name.txt")->get("alt") ?>
        <?php else : ?>
            <?php $image_alt_text = $image_name ?>
        <?php endif; ?>
            <div class="column-shrink pd-2">
                <div class="bgr-dark-2 pd-2">
                    <div class='content-center'>
                        <img title="<?php echo $image_alt_text ?>" id="admin-image-<?php echo $image_name ?>" src="<?php echo $image ?>" alt="<?php echo $image_alt_text ?>" rel="easySlider" loading="lazy" class="bd-round-3 height-128p">
                    </div>
                    <div class="content-right content-center-xsm pd-1 header-6">
                        <i redirect="admin/app/media-picture-show/<?php echo $image_name ?>@<?php echo $image_ext ?>" class="fa fa-eye mgx-1 cursor-point"></i>
                        <i redirect="admin/app/media-pictures-delete/<?php echo $image_name ?>@<?php echo $image_ext ?>" class="fa fa-trash mgx-1 t-error cursor-point"></i>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
</div>