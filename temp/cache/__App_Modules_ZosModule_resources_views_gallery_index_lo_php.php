<div class="pd-2">
    <?php if(!empty($collections)) : ?>
    <div class="header-2 content-center t-zos pdy-2">Kolekce: </div>

    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
    <div class="pdy-2 content-center">
        <button redirect="zos/app/gallery-create-collection" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat novou kolekci</button>
    </div>
    <?php endif; ?>

    <div class="row cols-4 cols-2-xsm cols-2-sm cols-3-md">
        <?php foreach($collections as $collection) : ?>
            <div class="column-shrink pd-1">
                <div 
                    redirect="zos/app/gallery-show-collection/<?php echo $collection['url'] ?>" 
                    id="image-hover-resize-<?php echo $collection['url'] ?>" 
                    
                    <?php if(file_exists("./App/Modules/ZosModule/public/img/collections/".$collection['url']."/main.png")) : ?>
                    style="background: url('<?php echo modasset('img/collections/'.$collection['url'].'/main.png') ?>'); background-size: 120%; background-position: center; background-repeat: no-repeat" 
                    <?php else : ?>
                    style="background: url('<?php echo modasset('img/noimage.png') ?>'); background-size: 100%; background-position: center; background-repeat: no-repeat" 
                    <?php endif; ?>
                    
                    class="background-dark-2 cursor-point bd-dark bd-round-3"
                >
                    <div class="pdx-3 height-256p mg-auto-all">
                        <div class="header-5 subheader-2-xsm t-bold background-dark pd-1 pdx-2 bd-round-3"><?php echo $collection['title'] ?></div>
                    </div>
                    
                </div>
                <div class="background-dark pd-1 content-right">
                    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
                        <button redirect="zos/app/gallery-edit-collection/<?php echo $collection['url'] ?>" class="button button-info bd-round-4 mgx-1"><i class="fa fa-edit"></i></button>
                        <button redirect="zos/app/gallery-delete-collection/<?php echo $collection['url'] ?>" class="button button-info bd-round-4"><i class="fa fa-trash"></i></button>
                    <?php endif; ?>
                </div>
            </div>

            <script>
                $("#image-hover-resize-<?php echo $collection['url'] ?>").hover(() => {
                    $("#image-hover-resize-<?php echo $collection['url'] ?>").animate({"background-size": "150%"}, 200);
                }, () => {
                    $("#image-hover-resize-<?php echo $collection['url'] ?>").animate({"background-size": "120%"}, 200);
                });
            </script>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <div class="header-2 content-center">Prozatím zde nejsou žádné kolekce</div>
    <?php endif; ?>
</div>