<div class="pd-2">
    <div class="">
        <button type='button' onClick='window.history.back()' class='button-small button-zos bd-round-symetric pdx-3'><i class='fa fa-chevron-left'></i> Zpět</button>
    </div>
    <div class="pdy-1 content-center header-1 t-zos">
        Úprava stránky:
    </div>

    <div class="content-center">
        <?php echo $page['title'] ?>
    </div>

    <form method="post" action="/zos/app/about-update">
        <input hidden type="text" name="token" value="32b80cfe28c08d53be9ce577f20899b759fd9ecde78f09b2f9c406ad4e6e5361"> <input hidden type="text" name="SID" value="547eee76ddc777bacf6b14a3d5fc7a43">
        <input hidden type='text' name='method' value='update'>
        <input hidden name="url" value="<?php echo $page['url'] ?>">
        <div class="mgy-2 form-line">
            <label for="title">Název stránky</label><br>
            <input id="title" name="title" validation="required,maxchars128" class="input-dark width-50 width-75-sm width-100-xsm pd-2" value="<?php echo $page['title'] ?> ">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Obsah: </label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>