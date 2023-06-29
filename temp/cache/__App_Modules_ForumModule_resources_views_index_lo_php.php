<div class="content-center header-1 pdy-1">
    Fórum
</div>

<?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
<div class="pd-2 content-center">
    <button redirect="forum/theme/create" class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Nové téma</button>
</div>
<?php endif; ?>

<div class="row">
    <div id="forum-margin" class="column-1 column-10-xsm column-10-sm display-0-xsm display-0-sm"></div>
    <div class="column-7 column-10-xsm pd-2">

        <?php foreach($themes as $theme) : ?>
            <div class="mgy-4 bd-round-3 bd-2 bd-solid" style="border-color: <?php echo $style['main_color'] ?>;">
                <div class="pd-2 bd-round-top-3" style="background-color: <?php echo $style['main_color'] ?>;">
                    <div class="row">
                        <div class="column-6">
                            <div class="header-6 t-bold pdy-1" style="color: <?php echo $style['text_main_color'] ?>">
                                <span redirect="forum/theme/show/<?php echo $theme['url'] ?>" class="t-info-hover cursor-point" style="color: <?php echo $style['text_main_color'] ?>;"><i class="<?php echo $theme['icon'] ?>"></i> <?php echo $theme["name"] ?></span>
                            </div>
                            <div class="t-italic" style="color: <?php echo $style['text_second_color'] ?>">
                                <?php echo $theme["_content"] ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="row-reverse cols-auto">
                                <div class="column-shrink">
                                    <a onClick="$('#categories-block-<?php echo $theme['id'] ?>').slideToggle(300)" event-toggle-class="click:fa-chevron-down:fa-chevron-up:#theme-toggle-<?php echo $theme['id'] ?>" class="background-dark-3-hover pd-1 bd-round-symetric cursor-point">
                                        <i id="theme-toggle-<?php echo $theme['id'] ?>" class="fa fa-chevron-up t-create t-bold"></i>
                                    </a>
                                </div>

                                <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
                                <div class="column-shrink">
                                    <button redirect="forum/category/create/<?php echo $theme['url'] ?>" class="button button-success bd-solid border-round-symetric mgx-2 cursor-point">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                                <div class="column-shrink">
                                    <button redirect="forum/theme-edit/<?php echo $theme['url'] ?>" class="button-small button-warning bd-solid border-round-symetric mgx-2 cursor-point">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                                <div class="column-shrink">
                                    <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat téma? Kategorie a příspěvky se smažou také', () => {$('#theme-delete-<?php echo $theme['url'] ?>').submit()})" class="button-small button-error bd-solid border-round-symetric mgx-2 cursor-point">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <form id="theme-delete-<?php echo $theme['url'] ?>" method="post" action="/forum/theme-delete/<?php echo $theme['url'] ?>" class="display-0">
                                        <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
                                        <input hidden type='text' name='method' value='delete'>

                                        <input name="url" value="<?php echo $theme['url'] ?>">
                                        <input type="submit">
                                    </form>
                                </div>
                                <?php endif; ?>

                                <div class="column-shrink">
                                    <i class="fa fa-file"></i> <sub>(<?php echo count($theme["categories"]) ?>)</sub>
                                </div>
                                
                            </div>
                            
                            
                        </div>
                    </div>
                    
                </div>

                <!-- Categories block -->
                <div id="categories-block-<?php echo $theme['id'] ?>" class="">

                    <?php foreach($theme["categories"] as $category) : ?>
                    <hr>
                        <!-- One Category block -->
                        <div class="bd-bottom-dark categories-block">
                            <div class="row">

                                <!-- Category name -->
                                <div class="column-4 column-7-xsm header-6 subheader-2-xsm subheader-1-sm pd-2">
                                    <div redirect="forum/posts/category/<?php echo $category['url'] ?>" class="t-warning-hover cursor-point">
                                        <i class="mgx-2 <?php echo $category['icon'] ?>"></i> 
                                        <?php echo $category["name"] ?>
                                    </div>
                                </div>

                                <!-- Category details = comments, threads etc.. -->
                                <div class="column-6 column-3-xsm pd-2">
                                    <div class="row-reverse row-center-xsm cols-8 cols-2-xsm header-6 subheader-1-xsm">
                                        <div id="category-info-column" class="column-shrink content-center">
                                            <i class="fa fa-check-circle t-success"></i> <sub><?php echo $category['count_posts_solved'] ?>x</sub>
                                        </div>
                                        <div id="category-info-column" class="column-shrink content-center">
                                            <i class="fa fa-info-circle t-info"></i> <sub><?php echo $category['count_posts_open'] ?>x</sub>
                                        </div>
                                    </div>
                                </div>

                                <!-- LAST Post  -->
                                <!-- <div class="column-10 content-right content-center-xsm pd-2">
                                    <div class="">
                                        <div class="header-6"><i class="fa fa-clock"></i> MichaelMik | <small>25.2.2023 15:36</small></div>
                                        <div class="">Jak mohu zapsat tento skript napsaný v Playmakeru do UNode?Jak mohu zapsat tento skript napsaný v Playmakeru do UNode?</div>
                                    </div>
                                </div> -->
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div copy-attr="forum-margin:class"></div>

</div>