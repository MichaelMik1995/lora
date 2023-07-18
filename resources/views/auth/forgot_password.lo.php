<div class="row row-center-lrg row-center-xlrg cols-3 cols-1-xsm">
    <div id="login-column" class="column"></div>
    
    <div class="column bgr-dark-3 pd-2 bd-round-3 mgy-20">
        <div class="form-line header-2 header-3-xsm t-info t-bolder content-center">
            {{ lang("forgot_header") }}
        </div>

        <form id="login" method="POST" action="/auth/send-recover-password-key" class="bd-dark-2 pd-1 bd-round-3">
            @csrfgen
            @request(insert)
            
            <div class="form-line mgy-4"> 
                <label for="email" class="t-first-upper">{{ lang("recover_email_field") }} </label>
                <input required class="input-dark pd-2 width-100 " type="email" name="email" id="email">
            </div>

            <div class="form-line">
            <button class="button button-info" type="submit">{{ lang("button_send") }}</button>
            </div>
        </form>
        
        
        
    </div>
    
    <div copy-attr="login-column:class"></div>
</div>
