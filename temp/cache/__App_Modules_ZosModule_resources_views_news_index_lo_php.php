<div class="content-center t-big-3 header-1-xsm t-zos t-bold pdy-3">
    Novinky
</div>

<!-- ADMIN Section -->
<?php if(in_array("admin", [''])) : ?>
<div class="content-center pdy-2">
    <button redirect="zos/app/news-create" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Nový příspěvek</button>
</div>
<?php endif; ?>

<div class="">
    <?php foreach($news as $new) : ?>
        <?php if($new["validated"] == 1) : ?>
        <div class="mgy-4 mgy-2-xsm row pd-2 background-dark-3 bd-round-2 bd-top-warning bd-1">
            <?php if(file_exists("./App/Modules/ZosModule/public/img/news/".$new['url']."/thumb/main.png")) : ?>
                <div class="column-2 column-10-xsm pdx-3 content-center-xsm">
                    <img rel="easySlider" src="<?php echo modasset('img/news/'.$new['url'].'/thumb/main.png') ?>" class="height-100 height-128p-xsm bd-round-3">
                </div>
            <?php endif; ?>

            <div class="column-8">
                
                <!-- Admin section -->
                <div class=" pd-2">
                    <div class="row">
                        <div class="column header-4 header-6-xsm t-zos">
                            <?php echo $new["title"] ?>
                        </div>

                        
                        <?php if(in_array("admin", [''])) : ?>
                        <div class="column-3 content-right">
                            <button redirect="zos/app/news-edit/<?php echo $new['url'] ?>" class="button-circle button-warning width-28p height-28p mgx-1"><i class="fa fa-edit"></i></button>
                            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat příspěvek?', () => { $('#new-delete-<?php echo $new['id'] ?>').submit() })  " class="button-circle button-error width-28p height-28p"><i class="fa fa-trash"></i></button>
                        </div>
                        <form id="new-delete-<?php echo $new['id'] ?>" class="display-0" method="post" action="/zos/app/news-delete">
                            <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="0d3617bb70b65bfc97c053debacc2ed5">
                            <input hidden type='text' name='method' value='delete'>

                            <input name="url" value="<?php echo $new['url'] ?>">
                            <input type="submit">
                        </form>
                        <?php endif; ?>
                    </div>
                   
                    
                </div>

                
                    
                
                <div class="subheader-3-xsm pdx-2">
                    <i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s", $new['updated_at']) ?>
                </div>

                <div class="pdy-3 pdx-2">
                    <?php echo $new["_content"] ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>