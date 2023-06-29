<div class="t-big-2 t-zos t-bold content-center pdy-3">
    Naše služby
</div>

<div class="mgy-2">
    <?php foreach($services as $service) : ?>
    <?php if($service["type"] != "1") : ?>
        <div class="row mgy-5">

            <!-- Left Image -->
            <div class="column-2 column-10-xsm content-center-xsm">
                <img src="<?php echo modasset('img/zachranka.png') ?>">
            </div>

            <!-- Text -->
            <div class="column-6 column-10-xsm">
                <div class="content-center header-2 t-bolder">
                    <span redirect="zos/app/service-show/<?php echo $service["url"] ?>" class="t-hover-warning cursor-point"><?php echo $service["name"] ?></span>
                </div>
                <div class="pdy-2 content-justify">
                    <?php echo $service["short_description"] ?>
                </div>
            </div>

            <!-- Right Image -->
            <div class="column-2 column-10-xsm display-0-xsm">
                <img src="<?php echo modasset('img/zs-dalovice.png') ?>">
            </div>
        </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>