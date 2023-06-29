<div class="pd-2">

    <div class="pd-2">
        <button redirect="zos/app/gallery" class="button button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i></button>
    </div>

    <div class="header-2 content-center t-zos pdy-2">
        Upravit kolekci: <span class="t-bolder"><?php echo $collection['title'] ?></span>
    </div>

    <form method="post" action="/zos/app/gallery-update-collection" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
        <input hidden type='text' name='method' value='insert'>

        <input hidden type="text" name="url" value="<?php echo $collection['url'] ?>">
        

        <div class="form-line">
            <label for="title">Název kolekce:</label><br>
            <input type="text" id="title" name="title" validation="required,maxchars128" class="input-dark pd-2 width-30 width-100-xsm" placeholder="Aa..." value="<?php echo $collection['title'] ?>">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Popis kolekce:</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line content-center-xsm">
            <label for="image">Změni hlavní obrázek:</label><br>
            <input type="file" name="image" class="input-dark-2 pd-2 width-30 width-75-xsm">

            <div class="mgy-3 form-line content-center-xsm">
            <label>Aktuální obrázek: </label><br>
            <?php if(file_exists("./App/Modules/ZosModule/public/img/collections/".$collection['url']."/main.png")) : ?>
                <img src="./App/Modules/ZosModule/public/img/collections/<?php echo $collection['url'] ?>/main.png" class="height-128p">      
            <?php else : ?>
                <img src="./App/Modules/ZosModule/public/img/collections/<?php echo $collection['url'] ?>/main.png" class="height-128p"> 
            <?php endif; ?>
            </div>
        </div>

        <div class="form-line content-center-xsm">
            <button class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat kolekci</div>
        </div>
    </form>
</div>