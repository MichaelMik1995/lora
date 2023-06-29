<fieldset>
    <legend>Generovat přihlašovací heslo</legend>
    <div class="pd-1">
        <form method="post" action="/admindev/app/util-generate-psw">
            <input hidden type="text" name="token" value="9ecbd21691e8801dd624b471ea7810279795b1f58a33b4f305693f4fb79a1281"> <input hidden type="text" name="SID" value="a614f1ed0c475248ad8bb2db6b06c249">
            <input hidden type='text' name='method' value='default'>

            <div class="form-line">
                <input id="password" type="password" name="gen-password" class="input-dark pd-2 width-45 width-75-xsm">
                <button onClick="toggleViewPassword('#password')" type="button" class="button button-bd-info">Show</button>
                <button type="submit" class="button button-warning">Generovat</button>
            </div>
        </form>
    </div>
</fieldset>
