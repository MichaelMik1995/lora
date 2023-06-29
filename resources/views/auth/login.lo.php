<div class="row">
    <div id="login-column" class="column-3 column-10-xsm column-1-sm column-2-md"></div>
    
    <div class="column-4 column-10-xsm column-8-sm column-6-md background-dark-3 pd-2 bd-round-3 content-center mgy-10">
        <form id="login" method="POST" action="/auth/do-login">
            @csrfgen
            <input hidden type="text" name="method" value="update">
            <div class="form-line header-3">
                Přihlásit se
            </div>
            <div class="form-line input-labeled input-labeled-create mgy-4">  
                <input required class="pd-2 width-100 " type="text" name="name" id="name">
                <span>Jméno</span>
            </div>
            
            <div class="form-line input-labeled input-labeled-create mgy-4">
                <input required class="pd-2 width-100" type="password" name="password" id="password">
                <span>Heslo</span>
            </div>
        </form>
        
        <div class="">
            <button onClick="$('#login').submit()" class="button-large button-create bd-round-symetric" type="submit">Přihlásit se</button>
            <button onClick="redirect('auth/register')" class="button-large button-bd-warning bd-round-symetric mgx-3" type="submit">Zaregistrovat se</button>
        </div>
        
    </div>
    
    <div copy-attr="login-column:class"></div>
</div>
