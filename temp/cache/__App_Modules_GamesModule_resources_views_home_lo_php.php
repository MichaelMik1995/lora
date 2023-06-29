<div class="display-xsm display-sm display-md display-lrg display-xlrg"></div>

<!-- Main header -->
<div class="t-big-3 header-3-xsm header-1-sm t-bolder content-center t-create">
    Vítejte v herně DXGamePRO!
</div>
<div class="content-center header-5 pdy-1-xsm pdy-1-sm pdy-1-xlrg">
    Více než 300 her...
</div>

<!-- Genre navigation -->
<div class="mgy-2 row cols-10 cols-2-xsm cols-4-sm cols-8-xlrg background-bd-create">

    <!-- Recomended button -->
    <div class="column-shrink background-create-hover pd-1 content-center cursor-point scale-12-hover anim-all-fast">
        <a href="games" class="header-5 header-3-xlrg t-light"><i class="fa fa-home"></i> Hlavní</a>
    </div>

    <div class="column-shrink background-create-hover pd-1 content-center cursor-point scale-12-hover anim-all-fast">
        <a class="header-5 header-3-xlrg t-light"><i class="fa fa-star"></i> Doporučené</a>
    </div>

    <!-- Game genres loop -->
    <?php foreach($genres as $genre) : ?>
    <div redirect="games/app/board/<?php echo $genre['slug'] ?>" class="column-shrink background-create-hover pd-1 content-center cursor-point anim-all-fast">
        <a class="header-5 header-3-xlrg t-light"><?php echo $genre["title"] ?></a>
    </div>
    <?php endforeach; ?>
    
</div>

<!-- Submenu content -->
<div class="row pdx-4 pdy-3">

    <!-- First column = NEW Game button -->
    <div class="column">
        <?php if('' == '1') : ?>
            <button listen-url="app/game-create" url-valid="toggleClass:display-1:display-0" redirect="games/app/game-create" class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Nová hra</button>
        <?php endif; ?>
    </div>

    <!-- Second column = Search game -->
    <div class="column content-right ">
        <div class="element-group element-group-small">
            <input type="search" placeholder="Název hry ..." class="input-info">
            <button class="button button-info"><i class="fa fa-search"></i> Hledat</button>
        </div>
    </div>
</div>

<!-- Dynamic content -->
<div class="pd-1">
    <?php $this->games_controll->loadView() ?>
</div>
