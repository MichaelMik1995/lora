<div class="">
    <form method="post" action="/zos/app/service-insert/">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
        <input hidden type='text' name='method' value='insert'>

        <div class="form-line">
            <label for="name">Název služby</label><br>
            <input id="name" required validation="required,maxchars128" type="text" name="name" class="input-dark pd-1 pdy-2 width-50 width-100-xsm pd-2-xsm">
            <div class="pd-1" valid-for="#name"></div>
        </div>

        <div class="form-line">
            <label for="short-description">Krátký text</label><br>
            <textarea required id="short-description" name="short-description" validation="required,maxchars1024" class="height-64p width-50 width-100-xsm v-resy pd-1 bd-round-3"></textarea>
            <div class="pd-1" valid-for="#short-description"></div>
        </div>

        <div class="form-line">
            <label for="content">Úplný popis služby</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <label for="type">Zobrazení služby:</label><br>
            <select name="type" class="input-dark pd-2 width-30 width-75-xsm">
                    <option value="1">Pouze v menu</option>
                    <option value="0" selected>Ve službách a v menu</option>
            </select>
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-symetric width-100-xsm pd-2-xsm header-6-xsm"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>