<div class="">
    <form method="post" action="/zos/app/station-status-insert">
        <input hidden type="text" name="token" value="5c1941e2c5dcb72b3c547efc4dea6e6b5dd0062cee9436c087c46d23e45c2c51"> <input hidden type="text" name="SID" value="3f12cfd34c2bca7a89d65b4c362f46eb">
        <input hidden type='text' name='method' value='insert'>

        <div class="form-line">
            <label for="name">Název statusu:</label><br>
            <input type="text" name="name" id="name" class="input-dark width-30 width-100-xsm pd-2" placeholder="Aa..." validation="required,maxchars128">
            <div class="pd-2" valid-for="#name"></div>
        </div>

        <div class="form-line">
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>
    </form>
</div>