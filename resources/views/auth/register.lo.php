<div class="pd-2 content-center">
    <button onClick="redirect('auth/login')" class="button button-basic bd-round-symetric"><i class="fa fa-chevron-left"></i> Zpět na přihlášení</button>
</div>

<div class='width-50 width-100-xsm width-100-sm background-dark-3 pd-3 bd-round-3 mg-auto mgy-3'>
    <form method='POST' action='/auth/do-register'>
        @csrfgen
        <div class='form-line input-labeled input-labeled-basic mgy-3'>
            <input required class='width-100 ' type='text' name='name' id='name'>
            <span>Jméno (Nepoužívejte znaky typu @ < > !)</span>
        </div>
        
        <div class='form-line input-labeled input-labeled-basic mgy-3'>
            <input autocomplete="off" required class='width-100' type='text' name='email' id='email'>
            <span>Email</span>
        </div>
        
        <div class='form-line input-labeled input-labeled-basic mgy-3'>
            <input required class='width-75 width-100-xsm' type='password' name='password1' id='password1'>
            <span>Heslo</span>
        </div>
        
        <div class='form-line input-labeled input-labeled-basic mgy-3'>
            <input required class='width-75 width-100-xsm' type='password' name='password2' id='password2'>
            <span>Heslo znovu</span>
        </div>
        
        <div class="form-line mgy-2 content-center-xsm mgy-3">
            <label for="gender">Jaké jste pohlaví? </label>
            <select name="gender" class='mgx-2 background-dark bd-1 pd-2'>
                <option class="background-dark-2 pd-2" value="man" selected>Muž</option>
                <option class="background-dark-2 pd-2" value="woman">Žena</option>
            </select>
        </div>
        
        <div class='form-line input-labeled input-labeled-basic mgy-5'>
            <input required class='width-40 width-100-sm' type='number' name='antispam' id='antispam'>
            <span>Antispam: Následující rok</span>
        </div>
        
        <div class="form-line content-center-sm">
            <a class="ws-href t-warning subheader-3" target="_blank" href="https://dxgamepro.cz/dxgamepro/show/226466">Přečíst si podmínky pro registraci</a>
        </div>
        
        <div class="form-line content-center-sm mgy-2 pd-2 background-dark-2 bd-round-3">
            <label for="conditions">Souhlasíte s podmínkami a pravidly našeho webu?</label>
            <select class="background-dark bd-1 pd-2 mgx-2 width-50-sm content-center-sm mgy-2-sm" name="confirmed">
                <option class="background-dark-2 pd-2" value="confirmed">Ano</option>
                <option class="background-dark-2 pd-2" value="0" selected>Ne</option>
            </select>
        </div>
        
        <div class="form-line content-center-sm">
            <button class='button-large button-warning bd-round-symetric width-100-sm' type='submit'>Zaregistrovat</button>
        </div>
    </form>
</div>   