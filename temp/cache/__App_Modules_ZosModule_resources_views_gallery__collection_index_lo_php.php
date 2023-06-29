<div class="pd-1">

    <div class="pd-2">
        <button redirect="zos/app/gallery" class="button button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i></button>
    </div>

    <div class="background-dark-3 pdy-3 content-center bd-round-5">
        <div class="header-2 t-zos"><?php echo $collection['title'] ?></div>
        <div class="t-italic"><?php echo $collection['_description'] ?></div>
    </div>

    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
    <div class="pdy-2 content-center">
        <button redirect="zos/app/gallery-create/<?php echo $collection['url'] ?>" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat novou galerii</button>
    </div>
    <?php endif; ?>

    <?php if(!empty($items)) : ?>
        <?php foreach($items as $item) : ?>

        <?php $path = "./App/Modules/ZosModule/public/img/gallery/".$item['url'] ?>
            <div id="item-<?php echo $item['url'] ?>" class="mgy-5 ">

                <div class="row background-dark-2 bd-round-top-5">
                    <div class="column-2 column-4-xsm button-dark cursor-point pd-1" event-toggle-class="click:fa-chevron-up:fa-chevron-down:#gallery-item-view-<?php echo $item['id'] ?>" onClick="$('.gallery-item-<?php echo $item['id'] ?>').slideToggle(200)">
                        <span class="header-6 t-bold"><i class="fa fa-dog"></i> <?php echo $item["title"] ?></span>
                        <i id="gallery-item-view-<?php echo $item['id'] ?>" class="fa fa-chevron-down"></i>
                    </div>
                    <div class="column column-xsm content-right pd-1">
                        <span class=""><i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s", $item['updated_at']) ?> </span>
                    </div>
                </div>

                <div class="content-center background-dark-3 bd-round-bottom-5 pdy-2">
                    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
                    <div class="pd-2 content-right">
                        <button redirect="zos/app/gallery-edit/<?php echo $item['url'] ?>" class="button button-info bd-round-3 mgx-1"><i class="fa fa-edit"></i></button>
                        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tuto galerii?', () => { $('#gallery-item-delete-<?php echo $item['id'] ?>').submit() })" class="button button-info bd-round-3 mgx-1"><i class="fa fa-trash"></i></button>
                    </div>

                    <form id="gallery-item-delete-<?php echo $item['id'] ?>" method="post" action="/zos/app/gallery-delete" class="display-0">
                        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
                        <input hidden type='text' name='method' value='delete'>

                        <input type="text" name="url" value="<?php echo $item['url'] ?>">
                        <input type="text" name="collection" value="<?php echo $collection['url'] ?>">
                        <input type="submit">
                    </form>
                    <?php endif; ?>

                    <div class="display-0 gallery-item-<?php echo $item['id'] ?>">
                        <div class="pd-3 content-left content-justify-xsm">
                            <?php echo $item['_description'] ?>
                        </div>
                        <div>
                            <?php if(file_exists($path."/main.png")) : ?>
                            <img rel="easySlider" loading="lazy" src="<?php echo $path ?>/main.png" class="height-512p height-256p-xsm height-256p-sm height-256p-md">
                            <?php else : ?>
                            <img loading="lazy" src="<?php echo modasset('img/noimage.png') ?>" class="height-512p height-256p-xsm height-256p-sm height-256p-md">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mgy-2 row-center cols-6 cols-3-xsm pd-2 bd-top-dark-2">
                        <?php foreach(glob($path."/thumb/*") as $image) : ?>
                            <?php $image_file = str_replace($path."/thumb/","",$image) ?>
                            <?php $img = explode(".", $image_file) ?>
                            
                                <div class="column-shrink pd-1">
                                    <div class="">
                                        <img rel="easySlider" loading="lazy" src="<?php echo $image ?>" class="height-128p height-64p-xsm height-64p-sm bd-round-5">
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="header-2 t-error content-center pdy-2">Prozatím zde není žádná galerie</div>
    <?php endif; ?>
</div>