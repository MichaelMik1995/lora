<!-- Categories block -->
<div class="">
    <div class="pd-2">
        <button redirect="forum" class="button-circle width-32p height-32p bd-none" style="background-color: <?php echo $style['second_color'] ?>"><i class="fa fa-chevron-left"></i></button>
    </div>
    <div class="row pd-1" style="background-color: <?php echo $style['main_color'] ?>">
        <div class="column-6">
            <div class="header-6 t-bold pdy-1" style="color: <?php echo $style['text_main_color'] ?>">
                <i class="<?php echo $category['icon'] ?>"></i> <?php echo $category["name"] ?>
            </div>
            <div class="t-italic" style="color: <?php echo $style['text_main_color'] ?>">
                <?php echo $category["_content"] ?>
            </div>
        </div>
        <div class="column">
            <div class="row-reverse cols-auto">
                <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
                <div class="column-shrink">
                    <button redirect="forum/category/create/<?php echo $theme['url'] ?>"
                        class="button button-success bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
                <div class="column-shrink">
                    <button redirect="forum/theme/edit/<?php echo $theme['url'] ?>"
                        class="button-small button-warning bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-edit"></i>
                    </button>
                </div>
                <div class="column-shrink">
                    <button redirect="forum/theme/delete/<?php echo $theme['url'] ?>"
                        class="button-small button-error bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>

                <div class="column-shrink">
                    <i class="fa fa-file"></i> <sub>(<?php echo count($posts) ?>)</sub>
                </div>

            </div>


        </div>
    </div>

    <!-- USER action panel -->
    <div class="content-center pdy-2">
        <?php if('1' == '1') : ?> 
            <button redirect="forum/post/create/<?php echo $category['url'] ?>" class="button bd-round-symetric" style="background-color: <?php echo $style['second_color'] ?>; border-color: <?php echo $style['second_color'] ?>;"><i class="fa fa-plus-circle"></i> Nové vlákno</button>
        <?php endif; ?>
    </div>


    <!-- Button viewers -->
    <div class="content-right pdy-4">
    <button id="button-great" event-toggle-class="click:button-dark:button-success:#button-great"
        onClick="$('.post-success').slideToggle(200)" class="button button-success bd-round-3"><i
            class="fa fa-check"></i></button>
    <button id="button-bad" event-toggle-class="click:button-dark:button-info:#button-bad"
        onClick="$('.post-info').slideToggle(200)" class="button button-info bd-round-3"><i
            class="fa fa-question"></i></button>
</div>

    <!-- BEGIN read posts -->
    <div class="row cols-4 cols-3-md cols-1-xsm cols-2-sm">
        <?php foreach($posts as $post) : ?>
        <?php if($post["solved"] == 1) : ?>
            <?php $color = "success"; $icon = "check-circle" ?>
        <?php else : ?>
            <?php $color = "info"; $icon = "question-circle" ?>
        <?php endif; ?>
        <!-- One Post block -->
        <div class="column-shrink pd-1 post-<?php echo $color ?>">
            <div redirect="forum/post-show/<?php echo $post['url'] ?>" class="bgr-dark-2 bd-top-<?php echo $color ?> pd-2 bd-round-3 shift-yn-11-hover anim-shift-fast transparent-hover-75 cursor-point">
                <div class="pdy-1 content-right t-<?php echo $color ?>"><i class="fa fa-<?php echo $icon ?>"></i></div>
                <div class="row">
                    <div class="column-2">
                        <img class="bd-round-circle" src="<?php echo asset('img/avatar/'.$post['author'].'.png') ?>">
                    </div>
                    <div class="column-8">
                        <div class="pdx-5 header-6-xlrg t-bolder"><?php echo $post["title"] ?></div>
                        <div class="pdx-5 pdy-2">
                            <div class="row cols-auto">
                                <div class="column-shrink pd-1 t-info">
                                    <i class="fa fa-comments"></i> <?php echo $post['comments_count'] ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>