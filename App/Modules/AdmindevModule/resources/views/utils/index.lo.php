<fieldset>
    <legend>Generovat přihlašovací heslo</legend>
    <div class="pd-1">
        <form method="post" action="/admindev/app/util-generate-psw">
            @csrfgen
            @request(default)

            <div class="form-line">
                <input id="password" type="password" name="gen-password" class="input-dark pd-2 width-45 width-75-xsm">
                <button onClick="toggleViewPassword('#password')" type="button" class="button button-bd-info">Show</button>
                <button type="submit" class="button button-warning">Generovat</button>
            </div>
        </form>
    </div>
</fieldset>
