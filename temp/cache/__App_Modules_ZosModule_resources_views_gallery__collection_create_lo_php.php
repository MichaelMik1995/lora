<div class="pd-2">

    <div class="pd-2">
        <button redirect="zos/app/gallery" class="button button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i></button>
    </div>

    <form method="post" action="/zos/app/gallery-insert-collection" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="3d8062d0f41138091a31dfadfeb8d3defc1a08953fcf227629425c835a721c72"> <input hidden type="text" name="SID" value="452a0e31567db48046c2482167567030">
        <input hidden type='text' name='method' value='insert'>

        <div class="header-2 content-center t-zos pdy-2">Vytvořit novou kolekci: </div>

        <div class="form-line">
            <label for="title">Název kolekce:</label><br>
            <input type="text" id="title" name="title" validation="required,maxchars128" class="input-dark pd-2 width-30 width-100-xsm" placeholder="Aa...">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Popis kolekce:</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <label for="image">Hlavní obrázek:</label><br>
            <input type="file" name="image" class="input-dark pd-2 width-30 width-75-xsm">
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat kolekci</div>
        </div>
    </form>
</div>