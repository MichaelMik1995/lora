<div class="row row-center-lrg row-center-xlrg cols-3 cols-1-xsm">
    <div id="recover-column" class="column"></div>
    
    <div class="column bgr-dark-3 pd-2 bd-round-3 mgy-20">
        <div class="form-line header-2 header-3-xsm t-info t-bolder t-upper content-center">
            {{ lang("recover_header") }}
        </div>

        <form id="login" method="POST" action="/auth/do-recover-password" class="bd-dark-2 pd-1 bd-round-3">
            @csrfgen
            @request(update)
            
            <input hidden type="email" name="email" value="{{ $email }}">
            <input hidden type="text" name="key" value="{{ $key }}">

            <div class="form-line mgy-4"> 
                <label for="name" class="t-first-upper">{{ lang("recover_name_field") }}: </label>
                <input required class="input-dark pd-2 width-100 " type="text" name="name" id="name">
            </div>
            
            <div class="form-line mgy-4">
                <label for="password1" class="t-first-upper">{{ lang("recover_password1_field") }}: </label>
                <input required class="input-dark pd-2 width-100" type="password" name="password1" id="password1">
            </div>

            <div class="form-line mgy-4">
                <label for="password2" class="t-first-upper">{{ lang("recover_password2_field") }}: </label>
                <input required class="input-dark pd-2 width-100" type="password" name="password2" id="password2">
            </div>

            <div class='form-line mgy-5 content-center-xsm'>
                <label for="antispam" class="t-first-upper">{{ lang('register_antispam_field') }} ({{ lang('register_antispam_hint_field') }}): </label>
                <input required class='width-30 width-50-xsm input-dark pd-2' type='number' name='antispam' id='antispam'>
            </div>

            <div class="form-line mgy-4 content-center-xsm">
                <button type="submit" class="button button-info t-first-upper">{{ lang("recover_button_recover") }}</button>
            </div>
        </form>
        

        
        
    </div>
    
    <div copy-attr="recover-column:class"></div>
</div>

