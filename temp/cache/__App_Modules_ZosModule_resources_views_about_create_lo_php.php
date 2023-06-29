<div class="pd-2">

    <div class="">
        <button redirect="zos/app/about" class="button-small button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i><span class="display-0-xsm"> Všechny stránky</span></button>
    </div>
    <div class="pdy-2 content-center header-1 t-zos">
        Vytvořit novou stránku:
    </div>

    <form method="post" action="/zos/app/about-insert">
        <input hidden type="text" name="token" value="d3439ad0202c1d80fed611fb21c4bc8d4cd161ad22142d32e03c2851747cc716"> <input hidden type="text" name="SID" value="fef56326bf1ecaf8d0431b283a5fd887">
        <input hidden type='text' name='method' value='insert'>

        <div class="form-line">
            <label for="title">Název stránky</label><br>
            <input id="title" name="title" validation="required,maxchars128" class="input-dark width-50 width-75-sm width-100-xsm pd-2">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Obsah: </label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-file"></i> Přidat</button>
        </div>
    </form>
</div>