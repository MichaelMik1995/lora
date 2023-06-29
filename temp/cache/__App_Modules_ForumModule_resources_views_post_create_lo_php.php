<div class="">
    <form method="post" action="/forum/post/insert" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
        <input hidden type='text' name='method' value='insert'>
        <input hidden type="text" name="theme-url" value="<?php echo $theme_url ?>">
        <input hidden type="text" name="category-url" value="<?php echo $category_url ?>">

        <div class="form-line">
            <label for="name">Název vlákna:</label><br>
            <input tabindex="1" id="name" type="text" name="name" validation="required,maxchars256" class="input-dark pd-2 width-30 width-75-xsm">
        </div>

        <div class="form-line">
            <fieldset class="width-30 width-100-xsm bgr-dark-2">
                <legend>Vlákno pro:</legend>
                <div class="bgr-dark-2 pd-2">
                    Téma: <b><?php echo $theme_name ?></b> > Kategorie: <b><?php echo $category_name ?></b>
                </div>
            </fieldset>
        </div>

        <div class="mgy-2 form-line">
            <label for="content">Obsah:</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button class="button button-dxgamepro"><i class="fa fa-plus-circle"></i> Vložit</button>
        </div>
    </form>
</div>