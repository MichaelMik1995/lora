<div class="">
    <div class="header-3 t-zos pdy-2">Vytvořit přírustek: </div>
    <form method="post" action="/zos/app/station-animal-insert" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
        <input hidden type='text' name='method' value='insert'>

        <div class="form-line">
            <label for="name">Jméno:</label><br>
            <input type="text" name="name" id="name" class="input-dark width-30 width-100-xsm width-50-sm pd-2" placeholder="Aa..." validation="required,maxchars256">
            <div class="pd-2" valid-for="#name"></div>
        </div>
        
        <div class="form-line">
            <label for="statuses">Status</label><br>
            <select name="statuses" class="input-dark pd-2 width-50">
                <?php foreach($statuses as $status) : ?>
                    <option title="<?php echo $status['description'] ?>" value="<?php echo $status['slug'] ?>"><?php echo $status["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-line">
            <label for="content">Obsah</label><br>
            <?php echo $form ?>
        </div>

        <div class="row">
            <div class="column form-line">
                <label for="image">Hlavní obrázek (měl by být čtverec):</label><br>
                <input id="image" type="file" name="image" class="input-dark pd-2">
            </div>

            <div class="column form-line">
                <label for="images">Obrázky: (Max: 8)</label><br>
                <input id="images" type="file" multiple max="8" name="images[]" class="input-dark pd-2">
            </div>
        </div>
        

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>
    </form>
</div>