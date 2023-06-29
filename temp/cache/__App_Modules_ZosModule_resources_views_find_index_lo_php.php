<div class="pdy-5">

    <div class="content-center header-3 t-zos pdy-3"> Výsledky vyhledání fráze: <span class="t-bolder t-underline"><?php echo $search_string ?></span></div>
    <!-- STATION find -->
    <?php if(!empty($results['station-animals'][1])) : ?>

    <details open>
        <summary class="header-3 header-4-xsm"> Počet vyhledaných v záchranné stanici: <span class="t-info t-bolder"><?php echo count($results['station-animals'][1]) ?></span></summary>
        <?php foreach($results['station-animals'][1] as $animal) : ?>
        <div class="mgy-3 background-dark-2 bd-round-2 bd-1 pd-2 bd-top-warning">
            <div class="row pd-1">
                <div class="column-10">
                    <div class="">
                        <span class="header-3 t-zos t-light-hover cursor-point" redirect="zos/app/station-animals-show/<?php echo $animal['status'] ?>#item-<?php echo $animal['url'] ?>">Přejít na stanici <i class="fa fa-chevron-right"></i></span><br>
                        <span class="subheader-2"><?php echo $animal['status'] ?></span>
                    </div>
                    <?php if(in_array("admin", [''])) : ?>
                    <div class="pd-2 content-right">
                        <button redirect="zos/app/station-animal-edit/<?php echo $animal['url'] ?>" class="button-circle width-32p height-32p button-warning mgx-1"><i class="fa fa-edit"></i></button>
                        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat zvířátko?', () => { $('#animal-delete-<?php echo $animal['url'] ?>').submit() })" class="button-circle width-32p height-32p button-error"><i class="fa fa-trash"></i></button>
                    
                        <form class="display-0" id="animal-delete-<?php echo $animal['url'] ?>" method="post" action="/zos/app/station-animal-delete">
                            <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="631fa393fb0b9cef8062f30234362553">
                            <input hidden type='text' name='method' value='delete'>

                            <input type="text" name="url" value="<?php echo $animal['url'] ?>">
                            <input type="text" name="status" value="<?php echo $animal['status'] ?>">
                            <input type="submit">
                        </form>
                    </div>
                    <?php endif; ?>
                    <div class="header-4 pdy-1 t-bold t-zos">
                        <?php if(file_exists("./App/Modules/ZosModule/public/img/station/".$animal['url']."/images/thumb/main.png")) : ?>
                            <img class="height-64p width-64p bd-round-circle" src="<?php echo modasset('img/station/'.$animal['url'].'/images/thumb/main.png') ?>">
                        <?php else : ?>
                            <i class="fa fa-paw"></i> 
                        <?php endif; ?>
                        
                        <?php echo $animal["name"] ?>
                    </div>
                    <div class="mgy-1">
                        <i class="fa fa-clock"></i> <?php echo DATE('d.m.Y H:i:s', $animal["updated_at"]) ?>
                    </div>
                </div>
                <div class="column content-right">

                </div>
            </div>
            <div class="mgy-3 pdy-2 pdx-1 content-justify">
                <?php echo $animal["_content"] ?>
            </div>
            
            <div class="bd-top-dark-3 pdy-1 pdx-2 subheader-3 content-center content-right-xsm">
                Obrázky:
            </div>

            <div class="display-0 display-1-xsm pd-2 content-right header-6">
                <span onClick="$('#images-animals-<?php echo $animal['id'] ?>').slideToggle(200)" event-toggle-class="click:fa-chevron-down:fa-chevron-up:#images-animals-icon-<?php echo $animal['id'] ?>">
                    <i id="images-animals-icon-<?php echo $animal['id'] ?>" class="fa fa-chevron-down"></i>
                </span>
            </div>

            <div id="images-animals-<?php echo $animal['id'] ?>" class=" row-center cols-4 cols-1-xsm cols-4-sm cols-3-md pd-1 display-0-xsm">
                <?php foreach(glob("./App/Modules/ZosModule/public/img/station/".$animal['url']."/images/thumb/*") as $image) : ?>
                    <div class="column-shrink pd-2">
                        <div class="background-dark-3 bd-round-3 bd-dark pd-2 content-center">
                            <img alt="Obrázek zvířátka: <?php echo $animal['name'] ?>" loading="lazy" class="height-128p-lrg height-128p-xlrg height-auto height-64p-sm width-100-xsm bd-round-3 scale-11-hover anim-all-fast" rel="easySlider" src="<?php echo $image ?>"><br><br>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </details>
    <?php else : ?>
    <div class="header-2 header-4-xsm t-error pdy-2">V záchranné stanici nebyl nalezen žádný výsledek pro: <span class="t-bolder t-underline"><?php echo $search_string ?></span></span></div>
    <?php endif; ?>

    <p class="mgy-3 bd-top-dark"></p>

    <!-- GALLERY find -->
    <?php if(!empty($results['gallery'][1])) : ?>
        <details>
            <summary class="header-3 header-4-xsm"> Počet vyhledaných v galerii: <span class="t-info t-bolder"><?php echo count($results['gallery'][1]) ?></span> </summary>
            <?php foreach($results['gallery'][1] as $item) : ?>

            <?php $path = "./App/Modules/ZosModule/public/img/gallery/".$item['url'] ?>
                <div id="item-<?php echo $item['url'] ?>" class="mgy-5 ">

                    <div class="row background-dark-2 bd-round-top-5">
                        <div class="column-2 column-4-xsm button-dark cursor-point pd-1" event-toggle-class="click:fa-chevron-up:fa-chevron-down:#gallery-item-view-<?php echo $item['id'] ?>" onClick="$('.gallery-item-<?php echo $item['id'] ?>').slideToggle(200)">
                            <span class="header-6 t-bold"><i class="fa fa-dog"></i> <?php echo $item["title"] ?></span>
                            <i id="gallery-item-view-<?php echo $item['id'] ?>" class="fa fa-chevron-down"></i>
                        </div>
                        <div class="column column-xsm content-right pd-1">
                            <span class=""><i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s", $item['updated_at']) ?> </span>
                        </div>
                    </div>

                    <div class="content-center background-dark-3 bd-round-bottom-5 pdy-2">
                        <div class="content-left pd-2">
                            <span class="header-3 t-zos t-light-hover cursor-point" redirect="zos/app/gallery-show-collection/<?php echo $item['collection'] ?>#item-<?php echo $item['url'] ?>">Přejít do galerie <i class="fa fa-chevron-right"></i></span><br>
                            <span class="subheader-2"><?php echo $item['collection'] ?></span>
                        </div>

                        <?php if(in_array("admin", [''])) : ?>
                        <div class="pd-2 content-right">
                            <button redirect="zos/app/gallery-edit/<?php echo $item['url'] ?>" class="button button-info bd-round-3 mgx-1"><i class="fa fa-edit"></i></button>
                            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tuto galerii?', () => { $('#gallery-item-delete-<?php echo $item['id'] ?>').submit() })" class="button button-info bd-round-3 mgx-1"><i class="fa fa-trash"></i></button>
                        </div>

                        <form id="gallery-item-delete-<?php echo $item['id'] ?>" method="post" action="/zos/app/gallery-delete" class="display-0">
                            <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="631fa393fb0b9cef8062f30234362553">
                            <input hidden type='text' name='method' value='delete'>

                            <input type="text" name="url" value="<?php echo $item['url'] ?>">
                            <input type="text" name="collection" value="<?php echo $collection['url'] ?>">
                            <input type="submit">
                        </form>
                        <?php endif; ?>

                        <div class="display-0 gallery-item-<?php echo $item['id'] ?>">
                            <div class="pd-3 content-left content-justify-xsm">
                                <?php echo $item['_description'] ?>
                            </div>
                            <div>
                                <?php if(file_exists($path."/main.png")) : ?>
                                <img rel="easySlider" loading="lazy" src="<?php echo $path ?>/main.png" class="height-512p height-256p-xsm height-256p-sm height-256p-md">
                                <?php else : ?>
                                <img loading="lazy" src="<?php echo modasset('img/noimage.png') ?>" class="height-512p height-256p-xsm height-256p-sm height-256p-md">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mgy-2 row-center cols-6 cols-3-xsm pd-2 bd-top-dark-2">
                            <?php foreach(glob($path."/thumb/*") as $image) : ?>
                                <?php $image_file = str_replace($path."/thumb/","",$image) ?>
                                <?php $img = explode(".", $image_file) ?>
                                
                                    <div class="column-shrink pd-1">
                                        <div class="">
                                            <img rel="easySlider" loading="lazy" src="<?php echo $image ?>" class="height-128p height-64p-xsm height-64p-sm bd-round-5">
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </details>
    <?php else : ?>
    <div class="header-2 header-4-xsm t-error pdy-2">V galerii nebyl nalezen žádný výsledek pro: <span class="t-bolder t-underline"><?php echo $search_string ?></span></div>
    <?php endif; ?>    

    <p class="mgy-3 bd-top-dark"></p>

    <!-- NEWS find -->
    <?php if(!empty($results['news'][1])) : ?>

        <details>
            <summary class="header-3 header-4-xsm"> Počet vyhledaných v novinkách: <span class="t-info t-bolder"><?php echo count($results['news'][1]) ?> </summary>

            <?php foreach($results['news'][1] as $new) : ?>
                <?php if($new["validated"] == 1) : ?>
                <div class="mgy-4 mgy-2-xsm row pd-2 background-dark-3 bd-round-2 bd-top-warning bd-1">
                    <?php if(file_exists("./App/Modules/ZosModule/public/img/news/".$new['url']."/thumb/main.png")) : ?>
                        <div class="column-2 column-10-xsm pdx-3 content-center-xsm">
                            <img rel="easySlider" src="<?php echo modasset('img/news/'.$new['url'].'/thumb/main.png') ?>" class="height-100 height-128p-xsm bd-round-3">
                        </div>
                    <?php endif; ?>

                    <div class="column">
                        
                        <!-- Admin section -->
                        <div class="content-right pd-2">
                            <?php if(in_array("admin", [''])) : ?>
                            <button redirect="zos/app/news-edit/<?php echo $new['url'] ?>" class="button-circle button-warning width-32p height-32p mgx-1"><i class="fa fa-edit"></i></button>
                            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat příspěvek?', () => { $('#new-delete-<?php echo $new['id'] ?>').submit() })  " class="button-circle button-error width-32p height-32p"><i class="fa fa-trash"></i></button>
                        
                            <form id="new-delete-<?php echo $new['id'] ?>" class="display-0" method="post" action="/zos/app/news-delete">
                                <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="631fa393fb0b9cef8062f30234362553">
                                <input hidden type='text' name='method' value='delete'>

                                <input name="url" value="<?php echo $new['url'] ?>">
                                <input type="submit">
                            </form>
                            <?php endif; ?>
                        </div>

                        <div class="header-4 header-6-xsm pdy-1 t-zos">
                            <?php echo $new["title"] ?>
                        </div>
                        <div class="subheader-3-xsm">
                            <i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s", $new['updated_at']) ?>
                        </div>

                        <div class="pdy-3">
                            <?php echo $new["_content"] ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </details>
    <?php else : ?>
        <div class="header-2 header-4-xsm t-error pdy-2">V novinkách nebyl nalezen žádný výsledek pro: <span class="t-bolder t-underline"><?php echo $search_string ?></span></div>
    <?php endif; ?>


</div>