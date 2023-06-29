<div class="">
    <form method="post" action="/zos/app/service-update/<?php echo $service['url'] ?>">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
        <input hidden type='text' name='method' value='update'>

        <div class="form-line">
            <label for="name">Název služby</label><br>
            <input id="name" validation="required,maxchars128" type="text" name="name" class="input-dark pd-1 pdy-2 width-50 width-100-xsm" value="<?php echo $service['name'] ?>">
        </div>

        <div class="form-line">
            <label for="short-description">Krátký text</label><br>
            <textarea id="short-description" name="short-description" class="height-64p width-50 width-100-xsm v-resy pd-1 bd-round-3"><?php echo $service["short_description"] ?></textarea>
        </div>

        <div class="form-line">
            <label for="content">Úplný popis služby</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line content-center-xsm">
            <label for="type">Zobrazení služby:</label><br>
            <select name="type" class="input-dark pd-2 width-30 width-75-xsm width-30-sm">
                <?php if($service["type"] == 1) : ?>
                    <option value="1" selected>Pouze v menu</option>
                    <option value="0">Ve službách a v menu</option>
                <?php else : ?>
                    <option value="1">Pouze v menu</option>
                    <option value="0" selected>Ve službách a v menu</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-line content-center-xsm">
            <button class="button button-info width-75-xsm width-30-sm pd-2-xsm"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>