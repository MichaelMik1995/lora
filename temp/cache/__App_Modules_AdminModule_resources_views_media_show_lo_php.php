<div class="row">
    <div class="display-flex column-5 column-10-xsm content-center ali-center column-justify-center">
        <img rel="easySlider" class="width-95 width-100-xsm " src="./App/Modules/AdminModule/resources/img/user/<?php echo $user_uid ?>/<?php echo $picture['filename'] ?>.<?php echo $picture['file_extension'] ?>">
    </div>
    <div class="column-5 column-10-xsm mgy-2-xsm">
        <table rules="none" class="table table-medium">
            <tr class="t-bolder header-6 bgr-dark-2">
                <td>Parametr</td>
                <td>Hodnota</td>
            </tr>
            <tr>
                <td>Název souboru:</td>
                <td><?php echo $picture['filename'] ?>.<?php echo $picture['file_extension'] ?></td>
            </tr>
            <tr>
                <td>Název souboru:</td>
                <td><?php echo $picture['filename'] ?>.<?php echo $picture['file_extension'] ?></td>
            </tr>
            <tr>
                <td>Velikost souboru:</td>
                <td><?php echo real_filesize($picture['filesize']) ?></td>
            </tr>
            <tr>
                <td>typ MIME:</td>
                <td><?php echo $picture['filetype'] ?></td>
            </tr>
            <tr>
                <td>Rozlišení:</td>
                <td><?php echo $picture['width'] ?> x <?php echo $picture['height'] ?></td>
            </tr>

            <?php if(!empty($picture['exifdata'])) : ?>
            <tr class='bgr-dark-2'>
                <td>EXIF data:</td>
                <td>
                    <?php foreach($picture['exifdata'] as $key => $value) : ?>
                        <span class='t-bolder'><?php echo $key ?></span> = <?php if(is_array($value)) : ?> <?php echo print_r($value) ?> <?php else : ?> <?php echo $value ?> <?php endif; ?><br>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
        </table>

        <!-- Alternative text (SEO) -->
        <div class="form-line mgy-2">
            <label for="alt-text" class="t-bolder">Alternativní text:</label><br>
            <form method="post" action="/admin/app/picture-update-alt/<?php echo $picture['filename'] ?>">
                <input hidden type="text" name="token" value="538fb255d54af89e92b41f7ba41b2f0398771d0fb563701e146f7040854f618b"> <input hidden type="text" name="SID" value="315cd74ea61c616ae1f776cf144472c1">
                <input hidden type='text' name='method' value='get'>
                <input type="hidden" name="picture_name" value="<?php echo $picture['filename'] ?>">
                <textarea id="alt-text" name="alt_text" class="input-dark pd-2 width-50 width-100-xsm v-resy height-10" placeholder="Aa ..." validation="required,maxchars256"><?php echo $picture["alt_text"] ?></textarea>
                <div class="pd-1" valid-for="#alt-text"></div>
                <button class="button button-info">Uložit</button>
            </form>
        </div>
    </div>
</div>