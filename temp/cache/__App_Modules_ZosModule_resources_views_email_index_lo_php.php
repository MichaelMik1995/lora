<div class="pdy-2 content-center header-3 t-zos">
    Zaslat žádanku k odběu mazlíčka: <span class="t-bolder"><?php echo $name ?></span>
</div>

<form method="post" action="/zos/app/email-send">
    <input hidden type="text" name="token" value="e37abb6f5bf5a39629a8b25b691bfc564e4bbb05b596cf2bc5b241ff41f0b3fd"> <input hidden type="text" name="SID" value="708d8e214742725d8df062735252fb70">
    <input hidden type='text' name='method' value='default'>

    <input hidden name="animal-name" value="<?php echo $name ?>">
    <input hidden name="status" value="<?php echo $status ?>">
    <div class="form-line">
        <label for="name">Jméno a přijmení:</label><br>
        <input id="name" type="text" name="name" validation="maxchars128"
            class="input-dark pd-2 width-50 width-100-xsm">
        <div class="pd-1" valid-for="#name"></div>
    </div>

    <div class="form-line ">
        <div class="row width-50 width-100-sm width-75-md width-100-xsm">
            <div class="column-5 column-10-xsm">
                <label for="email">Email:</label><br>
                <input id="email" type="email" name="email" validation="maxchars128,email"
                    class="input-dark pd-2 width-90 width-100-xsm">
                <div class="pd-1" valid-for="#email"></div>
            </div>

            <div class="column-5 column-10-xsm">
                <label for="phone">Telefon:</label><br>
                    <div class="element-group element-group-medium">
                        <select name="area-code" class="button-zos">
                            <option value="420" selected>+420</option>
                            <option value="421">+421</option>
                            <option value="49">+49</option>
                            <option value="48">+48</option>
                            <option value="43">+43</option>
                        </select>
                        <input id="phone" type="number" name="phone" validation="maxchars128,int" class="input-zos pd-2 width-100-xsm">
                    </div>
                    <div class="pd-1" valid-for="#email"></div>
            </div>
        </div>
    </div>

    <div class="form-line">
        <?php echo $form ?>
    </div>

    <div class="form-line content-center-xsm">
        <button class="button button-zos bd-round-symetric"><i class="fa fa-envelope"></i> Poslat žádanku</button>
    </div>
</form>