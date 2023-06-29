<div class="">
    <form method="post" action="/zos/app/station-status-update/<?php echo $status['slug'] ?>">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
        <input hidden type='text' name='method' value='update'>

        <?php if($status["slug"] != "nezarazeno") : ?>
        <div class="form-line">
            <label for="name">Název statusu:</label><br>
            <input type="text" name="name" id="name" class="input-dark width-30 width-100-xsm pd-2" placeholder="Aa..." validation="required,maxchars128" value="<?php echo $status['name'] ?>">
            <div class="pd-2" valid-for="#name"></div>
        </div>
        <?php endif; ?>

        <div class="form-line">
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>