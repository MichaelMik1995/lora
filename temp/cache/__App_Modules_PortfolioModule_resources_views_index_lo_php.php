<?php if(in_array("admin", [''])) : ?>
<div class='pd-3 background-dark-3'>
    <div class='row cols-auto col-space-2'>
        <div class='column-shrink'>
            <button onClick="redirect('portfolio/create')" class='button-large button-cyan bd-round-symetric'><i class="fa fa-plus-circle"></i> Nový projekt</button>
        </div>
        <div class="column-shrink">
            <div class="element-group element-group-medium">
                <div class="background-cyan bd-none pdx-2">Vyhledat project:</div>
                <input type="search">
                <button class="button button-cyan"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row cols-4 cols-1-xsm">
    <?php foreach($projects as $project) : ?>
    
    <?php if($project['project_type'] == "web") : ?>
       <?php $color = "cyan";
        $icon = "earth";
        $text = "Webová stránka"; ?>
    <?php elseif($project['project_type'] == "module") : ?>
        <?php $color = "create";
        $icon = "wrench";
        $text = "LORA Modul"; ?>
    <?php elseif($project['project_type'] == "plugin") : ?>
        <?php $color = "warning";
        $icon = "plug";
        $text = "LORA Plugin"; ?>
    <?php endif; ?>
                
                
    <div class="column-shrink pd-1">
        <div class="background-dark-3 bd-<?php echo $color ?> bd-1 bd-round-3 pdy-3">

            <!-- Interactive image -> on hover -> change scale -->
            <div content-height-auto="homepage-projects-image" class="content-center">
                <img rel="easySlider" class="width-50 width-90-xsm width-90-sm bd-round-3 scale-11-hover" src="<?php echo $this->modasset('portfolio', 'img/portfolio/'.$project['project_url'].'/thumb/main.png') ?>"> 
            </div>

            <div content-height-auto="portfolio-index-content" class="pd-1 pdy-3">
                <div class="header-4 content-center"><?php echo $project['project_name'] ?></div>
                <div class="t-italic content-center pdy-5">
                    <?php echo $project['short_text'] ?>
                </div>
            </div>

            <div class="pdy-3 content-center">
                <button onClick="redirect('portfolio/show/<?php echo $project['project_url'] ?>')" class="header-6 pd-2 button-<?php echo $color ?> bd-round-symetric scale-11-hover anim-all">
                    <i class="fa fa-<?php echo $icon ?>"></i> <?php echo $text ?>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>