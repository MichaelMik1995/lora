<div class="pd-2">

    <div class="pd-2">
        <button redirect="zos/app/gallery-show-collection/<?php echo $collection['url'] ?>" class="button button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i></button>
    </div>
    <div class="header-2 header-4-xsm content-center t-zos pdy-2">Vytvořit novou galerii v kolekci: <span class="t-bolder"><?php echo $collection['title'] ?></span></div>
    <form method="post" action="/zos/app/gallery-insert" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
        <input hidden type='text' name='method' value='insert'>

        <input hidden type="text" name="collection" value="<?php echo $collection['url'] ?>">

        <div class="form-line">
            <label for="title">Název (Jméno zvířátka):</label><br>
            <input type="text" id="title" name="title" validation="required,maxchars128" class="input-dark pd-2 width-30 width-100-xsm" placeholder="Aa...">
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

        <div class="form-line content-center-xsm">
            <button class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat kolekci</div>
        </div>
    </form>
</div>