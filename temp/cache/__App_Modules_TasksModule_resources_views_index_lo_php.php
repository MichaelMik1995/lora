<div class="pd-1 pdx-2 bgr-dark-2 bd-top-dark">
    <div class="row">
        <div class="column-5 column-7-xsm">
            <div class="width-100 mg-auto">
                <a href="tasks/app/create-new" class="button button-dark bd-round-3"><i class="fa fa-plus-circle"></i> Vytvořit</a>
            </div>
        </div>
        <div class="column-5 column-3-xsm content-right">
            <button class="button-circle button-success width-32p height-32p"><i class="fa fa-bell"></i></button>
        </div>
    </div>
</div>

<div class="row pd-1">
    <div class="column-8 column-10-xsm">
        <?php $this->tasks_controll->loadView() ?>
    </div>
    <div class="column-2 column-10-xsm  bgr-dark-2 pdy-2 bd-top-dark bd-1">
        
            <?php if(!empty($my_projects)) : ?>
            <div class="header-4 pdy-2 content-center">
                Projekty s aktivnímy úkoly:
            </div>
                <?php foreach($my_projects as $project) : ?>
                <div class="mg-3 bgr-dark-3 pd-2">
                    <div class="t-bold pdy-1"><?php echo $project["project_name"] ?></div>
                        <div class="mgy-2 element-group element-group-medium">
                            
                            
                            <?php foreach($statuses as $status) : ?>
                                <div title="<?php echo $status['_description'] ?>" class="column pdy-1 pdx-4 content-center bgr-dark scale-12-hover transparent-hover-75 cursor-help" style="color: <?php echo $status['color'] ?>">
                                <i class="fa fa-<?php echo $status['icon'] ?>"></i> 0
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <div>
                        <i class="fa fa-clock"></i> Vytvořeno: <?php echo DATE("d.m.Y H:i", $project["created_at"]) ?>
                    </div>

                </div>
                <?php endforeach; ?>

            <?php else : ?>
            <div class="header-4 pdy-2">Zatím žádné</div>
            <?php endif; ?>
    </div>
</div>