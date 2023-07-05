<?php
$get_file_content = file_get_contents("../../../../resources/plugins/easytext/blockstyles/easytext_styles.json");
$get_json = json_decode($get_file_content, true, 4);

$blocks = $get_json["blocks"];
$spans = $get_json["spans"];
$texts = $get_json["texts"];
?>

<div class="easyText-Dialog_inner">

    <div class="header-2 content-center pdy-2">Bloky: </div>
    <div class="row cols-auto">

        <?php foreach ($blocks as $block): ?>
            <div name="block:<?= $block ?>" class="mg-1 column es_style easytext-block-style-<?= $block ?>">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
            </div>
        <?php endforeach; ?>

    </div>

    <div class="header-2 content-center pdy-2">Spany: </div>
    <div class="row cols-auto">

        <?php foreach ($spans as $span): ?>
            <div name="span:<?= $span ?>" class="mg-1 column es_style easytext-span-style-<?= $span ?>">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
            </div>
        <?php endforeach; ?>

    </div>

    <?php foreach ($texts as $text): ?>
        <div name="text:<?= $text ?>" class="mg-1 column es_style easytext-text-style-<?= $text ?>">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        </div>
    <?php endforeach; ?>

</div>
<div class="es_footer">Vyberte blok kliknutím</div>
</div>