<div class="row cols-1-xsm cols-2-sm cols-3-md cols-5-lrg cols-8-xlrg pd-2">
    <?php foreach(glob("./App/Modules/*") as $file) : ?>
    <?php $module = str_replace("./App/Modules/","",$file) ?>
    <?php $module_file = strtolower(str_replace("Module","",$module)) ?>

    <?php if($module != "bin") : ?>
    <div class="column-shrink pd-1 scale-xp-9-hover anim-all-normal">
        <div onClick="redirect('<?php echo $module_file ?>')" class="background-dark-2 background-dark-hover pd-2 bd-round-3 cursor-point">
            <?php echo str_replace("Module","",$module) ?>
        </div>
    </div>
    <br>
    <?php endif; ?>

    <?php endforeach; ?>
</div>