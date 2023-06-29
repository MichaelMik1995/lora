<div class="">
    <div class="header-3 t-zos pdy-2">Upravit přírustek: <?php echo $animal['name'] ?> </div>
    <form method="post" action="/zos/app/station-animal-update/<?php echo $animal['url'] ?>" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="406bca28d96564553b1891c0de96bc40110ec50098d9971c6e57ab79a36abe73"> <input hidden type="text" name="SID" value="8eb9eb0ee6621bf7d883560da6a8bf01">
        <input hidden type='text' name='method' value='update'>

        <input hidden name="status" value="<?php echo $animal['status'] ?>">
        <div class="form-line">
            <label for="name">Jméno:</label><br>
            <input type="text" name="name" id="name" class="input-dark width-30 width-100-xsm width-50-sm pd-2" placeholder="Aa..." validation="required,maxchars256" value="<?php echo $animal['name'] ?>">
            <div class="pd-2" valid-for="#name"></div>
        </div>
        
        <div class="form-line">
            <label for="statuses">Status</label><br>
            <select name="statuses" class="input-dark width-50-xsm width-50-sm pd-2">
                <?php foreach($statuses as $status) : ?>
                    
                    <option title="<?php echo $status['description'] ?>" value="<?php echo $status['slug'] ?>" <?php if($status['slug'] == $animal['status']) : ?> selected <?php endif; ?>><?php echo $status["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-line">
            <label for="content">Obsah</label><br>
            <?php echo $form ?>
        </div>

        <div class="mgy-2 row cols-2 cols-1-xsm cols-2-sm">

            <div class="column">
                <div class="">
                    Obrázek: 
                </div>

                <div content-height-auto="edit-images-content" class="pd-1 width-100 mg-auto-all">
                    <?php if(file_exists("./App/Modules/ZosModule/public/img/station/".$animal['url']."/images/main.png")) : ?>
                        <img class="bd-round-3 width-100" src="<?php echo modasset('img/station/'.$animal['url'].'/images/main.png') ?>">
                    <?php else : ?>
                        <div >
                            <i class="fa fa-paw t-big-1"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mgy-2 form-line content-center">
                    <label for="image">Změnit hlavní obrázek:</label><br>
                    <input id="image" type="file" name="image" class="input-dark pd-2">
                </div>
            </div>

            <div class="column">
                <div class="">
                    Obrázky: 
                </div>
                <div content-height-auto="edit-images-content" class="row-center cols-2 pd-1">
                        <?php foreach(glob("./App/Modules/ZosModule/public/img/station/".$animal['url']."/images/thumb/*") as $image) : ?>
                        <?php $image_name = str_replace("./App/Modules/ZosModule/public/img/station/".$animal['url']."/images/thumb/", "", $image) ?>
                        <?php $img = explode(".",$image_name) ?>
                        <?php $redirect_image = $img[0]."_".$img[1] ?>
                        <div id="<?php echo $img[0] ?>" class="column-shrink pd-2">
                            <div class="background-dark-3 bd-round-3 bd-dark pd-2 content-center">
                                <img class="height-128p bd-round-3 scale-11-hover anim-all-fast" rel="easySlider" src="<?php echo $image ?>"><br><br>
                                <button onClick="removeImage('<?php echo $redirect_image ?>', '<?php echo $animal['url'] ?>', '#<?php echo $img[0] ?>')" type="button" class="button-circle width-32p height-32p button-error"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>

                        
                        <?php endforeach; ?>

                        <script>
                            function removeImage(image_name, animal, column)
                            {
                                var posting = $.post("/zos/app/station-animal-image-delete", {
                                    image_name: image_name,
                                    animal: animal,
                                    token: "<?php echo $_SESSION['token'] ?>",
                                    method: "delete",
                                });

                                posting.always((data) => {console.log(data)});
   
                                posting.done(() => {$(column).remove();});
                                
                            }
                        </script>
                </div>
                <div class="mgy-2 form-line content-center">
                    <label for="images">Přidat obrázky: (Max: 8)</label><br>
                    <input id="images" type="file" multiple name="images[]" class="input-dark pd-2">
                </div>

            </div>
        </div>

        

        <div class="form-line content-center-xsm">
            <button type="submit" class="button button-info bd-round-symetric width-50-xsm width-50-sm"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>