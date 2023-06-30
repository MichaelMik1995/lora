<div class="row row-center-lrg row-center-xlrg cols-3 cols-1-xsm">
    <div id="login-column" class="column"></div>
    
    <div class="column bgr-dark-3 pd-2 bd-round-3 mgy-20">
        <div class="form-line header-2 header-3-xsm t-info t-bolder content-center">
            Přihlásit se
        </div>

        <form id="login" method="POST" action="/auth/do-login" class="bd-dark-2 pd-1 bd-round-3">
            @csrfgen

            <input hidden type="text" name="method" value="update">
            
            <div class="form-line mgy-4"> 
                <label for="name">Jméno: </label>
                <input required class="input-dark pd-2 width-100 " type="text" name="name" id="name">
            </div>
            
            <div class="form-line mgy-4">
                <label for="password">Heslo: </label>
                <input required class="input-dark pd-2 width-100" type="password" name="password" id="password">
            </div>

            <div class="content-center mgy-2">
                <button onClick="$('#login').submit()" class="button-large button-info bd-round-symetric" type="button"><i class="fa fa-key"></i> Přihlásit se</button>
                <button onClick="redirect('auth/register')" class="button-large button-bd-warning bd-round-symetric mgx-3" type="button"><i class="fa fa-user-plus"></i> Zaregistrovat se</button>
            </div>
        </form>
        
        
        
    </div>
    
    <div copy-attr="login-column:class"></div>
</div>
