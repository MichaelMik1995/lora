<div class="pd-1">
    <?php if(in_array("admin", [''])) : ?>
    <div class="pd-2 content-right">
        
        <button redirect="portfolio/edit/<?php echo $project['project_url'] ?>" class="button button-cyan bd-round-symetric"><i class="fa fa-edit"></i> Upravit</button>
    </div>
    <?php endif; ?>
    
    <div class="pd-2 content-center-xsm pd-1-xsm">
        <button redirect="portfolio" class="button-circle button-cyan width-32p height-32p"><i class="fa fa-chevron-left"></i></button>
    </div>
    
    <div class="row">
        <div  class="column-3 column-10-xsm column-10-sm column-5-md content-center">
            <div class=" t-big-3 pdy-3 pdy-1-xsm t-bolder"><?php echo $project['project_name'] ?></div>
            
            <div class=" background-cyan pd-1 bd-round-3 mgy-1">
                <a target="_blank" class="t-dark-2 t-bolder header-5" href="<?php echo $project['web_url'] ?>"><i class="fa fa-earth"></i> <?php echo $project['web_url'] ?></a>
            </div>
            
            <div class="t-bolder pdy-1">
                <i class="fa fa-cog"></i> <?php echo $project["technology"] ?>
            </div>
            
            <div class="row cols-3 cols-2-xsm pd-2 mgy-2 mgy-1-xsm background-dark-3 pd-1 bd-round-3 bd-dark">
                <?php foreach(glob("./App/Modules/PortfolioModule/resources/img/portfolio/".$project['project_url']."/thumb/*") as $image) : ?>
                <div class="column-shrink">
                   <img class="image-cover width-100 height-100 bd-round-3 bd-light bd-1" rel="easySlider" src="<?php echo $image ?>"> 
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="column-7 column-xsm column-sm column-md pdx-2">
            <img class=" bd-round-3" src="<?php echo $this->modasset('portfolio', 'img/portfolio/'.$project['project_url']."/main.png") ?>">
            <div class=" pdy-1-xsm pdy-3 content-center header-5">
                <q><?php echo $project["short_text"] ?></q>
            </div>
        </div>
    </div>
    
    <div class="row mgy-5">
        <div class="column-6 column-10-xsm background-dark-3 pd-1 bd-round-3">
            <div class="header-3 content-center">
                Podrobnosti
            </div>
            
            <div class="">
                <?php echo $project["_description"] ?>
            </div>
        </div>
        
        <div class="column column-xsm">
            <div class="header-3 content-center">
                Komentáře | Reference | Dotazy
            </div>
        </div>
    </div>
</div>
