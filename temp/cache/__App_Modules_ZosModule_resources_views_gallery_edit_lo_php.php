<div class="pd-2">
    <div class="pd-2">
        <button redirect="zos/app/gallery-show-collection/<?php echo $collection['url'] ?>#item-<?php echo $gallery['url'] ?>" class="button button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i></button>
    </div>

    <div class="header-2 header-4-xsm content-center t-zos pdy-2">Upravit galerii <span class="t-bolder"><?php echo $gallery['title'] ?></span> v kolekci: <span class="t-bolder"><?php echo $collection['title'] ?></span></div>
    <form method="post" action="/zos/app/gallery-update" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="799e181905f22c1b81ff8ee24947825b5ff6ffc3b45f0c9a1ba84c17da2136ca"> <input hidden type="text" name="SID" value="d046a1ccc14807085af34bd1cc349989">
        <input hidden type='text' name='method' value='insert'>

        <input hidden type="text" name="collection" value="<?php echo $collection['url'] ?>">
        <input hidden type="text" name="url" value="<?php echo $gallery['url'] ?>">

        <div class="form-line">
            <label for="title">Název (Jméno zvířátka):</label><br>
            <input type="text" id="title" name="title" validation="required,maxchars128" class="input-dark pd-2 width-30 width-100-xsm" placeholder="Aa..." value="<?php echo $gallery['title'] ?>">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Popis:</label><br>
            <?php echo $form ?>
        </div>


        <div class="row form-line">
            <div class="column-5">
                <label for="image">Hlavní obrázek:</label><br>
                <input type="file" name="image" class="input-dark pd-2 width-50 width-100-xsm">
            </div>

            <div class="column-5">
                <label for="image">Další obrázky (max: 8):</label><br>
                <input type="file" name="images[]" multiple class="input-create pd-2 width-50 width-100-xsm">
            </div>
        </div>

        <div class="mgy-2 row cols-2 cols-1-xsm cols-2-sm">

            <div class="column">
                <div content-height-auto="edit-images-content" class="pd-1 width-100 mg-auto-all">
                    <?php if(file_exists("./App/Modules/ZosModule/public/img/gallery/".$gallery['url']."/main.png")) : ?>
                        <img class="bd-round-3 width-100" src="<?php echo modasset('img/gallery/'.$gallery['url'].'/main.png') ?>">
                    <?php else : ?>
                        <img class="bd-round-3 width-100" src="<?php echo modasset('img/noimage.png') ?>">
                    <?php endif; ?>
                </div>
            </div>

            <div class="column">
                <div class="">
                    Obrázky: 
                </div>
                <div content-height-auto="edit-images-content" class="row-center cols-2 pd-1">
                        <?php foreach(glob("./App/Modules/ZosModule/public/img/gallery/".$gallery['url']."/thumb/*") as $image) : ?>
                        <?php $image_name = str_replace("./App/Modules/ZosModule/public/img/gallery/".$gallery['url']."/thumb/", "", $image) ?>
                        <?php $img = explode(".",$image_name) ?>
                        <?php $redirect_image = $img[0]."_".$img[1] ?>
                        <div id="<?php echo $img[0] ?>" class="column-shrink pd-2">
                            <div class="background-dark-3 bd-round-3 bd-dark pd-2 content-center">
                                <img class="height-128p bd-round-3 scale-11-hover anim-all-fast" rel="easySlider" src="<?php echo $image ?>"><br><br>
                                <button onClick="removeImage('<?php echo $redirect_image ?>', '<?php echo $gallery['url'] ?>', '#<?php echo $img[0] ?>')" type="button" class="button-circle width-32p height-32p button-error"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <script>
                            function removeImage(image_name, url, column)
                            {
                                var posting = $.post("/zos/app/gallery-image-delete", {
                                    image_name: image_name,
                                    url: url,
                                    token: "<?php echo $_SESSION['token'] ?>",
                                    method: "delete",
                                });

                                posting.always((data) => {console.log(data)});
   
                                posting.done(() => {$(column).remove();});
                                
                            }
                        </script>
                </div>
            </div>
        </div>

        <div class="form-line content-center-xsm">
            <button class="button button-info bd-round-symetric"><i class="fa fa-save"></i> Uložit galerii</div>
        </div>
    </form>
</div>