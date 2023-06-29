<div class="easyText-Dialog_inner" >
    <div class="es_block">
        <div class="row cols-auto">
                <?php foreach(glob("../../../../public/img/icon/emoji/*.svg") as $image) : ?> 
                    <?php $emot_name = str_replace(array("../../../../public/img/icon/emoji/",".svg"),"", $image); ?>
                    <div class="column-shrink pd-1">
                        <div class="bgr-dark pd-2 bd-round-3">
                            <img class="emoji-dialog-emoticon" id="<?= $emot_name ?>" src="<?= $image; ?>" title="<?= $emoji ?>"> 
                        </div>
                    </div>     
                <?php endforeach; ?>
        </div>
    </div>
</div>

