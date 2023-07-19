<?php
    $get_file_content = file_get_contents("../../../../resources/plugins/easytext/colors/text_colors.json");
    $get_json = json_decode($get_file_content, true, 4);
?>


<div class="easyText-Dialog_inner">
    <div class="">
        <div class="content-center header-1 pdy-2">Základní barvy</div>
        <div class="row cols-auto">
            <?php foreach($get_json["base-cols"] as $base_color) : ?>
                <div class="column-shrink pd-1">
                    <div name="<?= $base_color ?>" class="mg-auto-all pd-4 bd-round-4 cursor-point transparent-hover-50 dialog-color-choose" style="background-color: <?= $base_color ?>">
                        <div class="pdy-1 pdx-3 bgr-dark bd-round-symetric display-0-xsm"><?= $base_color ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <?php $schemes = $get_json; unset($schemes["base-cols"]); $i = 0; ?>
    <?php foreach($schemes as $colors) : ?>
        <?php $id = $i++; ?>
        <div class="mgy-3">
            <div class="header-3 pdy-1">Schéma <?= $id ?></div>
            <div class="row cols-auto">
                <?php foreach($colors as $color) : ?>
                    <div class="column-shrink pd-1">
                        <div name="<?= $color ?>" class="mg-auto-all width-32p height-32p bd-round-4 cursor-point transparent-hover-50 dialog-color-choose" style="background-color: <?= $color ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="mgy-2 es_footer">
        Nebo namíchejte vlastní: <input class="es_own_color" type="color" id="colorChooser"><br>
        <button class="button button-info bd-round-3" id="easyText_color_insert">Vložit vlastní barvu</button>
    </div>
</div>
