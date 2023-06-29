<div class="content-center pdy-5">
    <div class="header-1 t-zos">
        <?php echo $status["name"] ?>
    </div>
    <div class="t-italic">
        <?php echo $status["description"] ?>
    </div>
</div>

<div class="pd-2">

    <?php if(!empty($animals)) : ?>
        <?php foreach($animals as $animal) : ?>
        <div class="mgy-3 background-dark-2 bd-round-2 bd-1 pd-2 bd-top-warning">
            <div class="row pd-1">
                <div class="column-10">
                    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
                    <div class="pd-2 content-right">
                        <button redirect="zos/app/station-animal-edit/<?php echo $animal['url'] ?>" class="button-circle width-32p height-32p button-warning mgx-1"><i class="fa fa-edit"></i></button>
                        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat zvířátko?', () => { $('#animal-delete-<?php echo $animal['url'] ?>').submit() })" class="button-circle width-32p height-32p button-error"><i class="fa fa-trash"></i></button>
                    
                        <form class="display-0" id="animal-delete-<?php echo $animal['url'] ?>" method="post" action="/zos/app/station-animal-delete">
                            <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
                            <input hidden type='text' name='method' value='delete'>

                            <input type="text" name="url" value="<?php echo $animal['url'] ?>">
                            <input type="text" name="status" value="<?php echo $animal['status'] ?>">
                            <input type="submit">
                        </form>
                    </div>
                    <?php else : ?>
                        <?php if($status['slug'] == "domov-hledaji") : ?>
                            <div class="content-right pd-1">
                                <button onClick="$('#email-write-<?php echo $animal['url'] ?>').submit()" class="button button-zos bd-round-symetric"><i class="fa fa-envelope"></i> Chci mazlíčka </button>

                                <form id="email-write-<?php echo $animal['url'] ?>" method="post" action="zos/app/email-write" class="display-0">
                                    <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
                                    <input hidden type='text' name='method' value='default'>
                                    <input type="text" name="name" value="<?php echo $animal['name'] ?>">
                                    <input type="text" name="url" value="<?php echo $animal['url'] ?>">
                                    <input type="submit">
                                </form>
                            </div>
                            <?php endif; ?>
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
    <?php else : ?>
        <div class="header-1 content-center">Prozatím zde nikoho nemáme</div>
    <?php endif; ?>
</div>