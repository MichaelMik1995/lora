<div class="pd-2 content-center header-1 t-zos">
    O nás: Rozcestník
</div>

<?php if(in_array("admin", [''])) : ?>
<div class="pd-1 content-center-xsm">
    <button redirect="zos/app/about-create" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Nová stránka</button>
</div>
<?php endif; ?>

<div class="pd-2">
    <?php if(!empty($pages)) : ?>
        <?php foreach($pages as $page) : ?>
            <div redirect="zos/app/about-show/<?php echo $page['url'] ?>" class="mgy-2 pd-1 cursor-point t-warning-hover">
                <i class="fa fa-chevron-right"></i> <?php echo $page["title"] ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="header-3 t-bold">
            Prozatím zde není žádná stránka
        </div>
    <?php endif; ?>
</div>