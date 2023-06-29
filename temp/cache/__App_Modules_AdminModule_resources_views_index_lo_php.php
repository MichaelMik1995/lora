
<div class="row pdx-5 bgr-dark-2">
    <div class="column-2 display-flex">
        <div class="row cols-auto col-space-1 header-4 ali-center">
            <div id="admin-header-panel-column" class="column-shrink bgr-dark-3-hover pd-1 cursor-point bd-round-3 t-info"><i class="fa fa-plus"></i></div>
            <div redirect="admin/app/security" copy-attr="admin-header-panel-column:class"><i class="fa fa-shield"></i></div>
            <div redirect="admin/app/seo" copy-attr="admin-header-panel-column:class"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
            <div class="column-shrink pd-1"> | </div>
            
        </div>
    </div>
    
    <div class="column display-flex column-justify-end ali-center">
        <span class="t-bolder">Admin</span><p class="mgx-1"></p><img class="height-40p bd-round-circle" src="<?php echo asset('img/avatar/32/111111111.png') ?>" alt="admin-header-user-111111111">
    </div>
</div>


<div class="row mgy-5">
    <div class="column-1">
        <?php foreach($hrefs as $href) : ?>
            <div redirect="admin/app/<?php echo $href['href'] ?>" class="row pd-2 cursor-point t-info-hover bd-left-dark-2 mgy-2 bd-left-info-hover anim-all-fast bgr-dark-2-hover">
                <div class="column-2 column-10-xsm content-center-xsm"><i class="fa fa-<?php echo $href['icon'] ?>"></i></div>
                <div class="column column-10-xsm display-0-xsm"><?php echo $href['name'] ?></div>
                <div class="column-2 column-10-xsm content-right content-center-xsm"> 
                <?php if($href['notification'] > 0) : ?>
                    <sup class="t-info"><?php echo $href['notification'] ?></sup>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
    <!-- Dynamic content -->
    <div class="column-9 pd-2">
        <?php $this->splitter_controll->loadView() ?>
    </div>
    
</div>