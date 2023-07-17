
<div class="row row-center-lrg row-center-xlrg cols-3 cols-1-xsm">
    <div class="column"></div>
    <div class='column background-dark-3 pd-3 bd-round-3 mgy-3'>

        <div class="content-center header-2 header-3-xsm t-bold t-warning pdy-2">
            {{ lang('register_header') }}
        </div>

        <form method='POST' action='/auth/do-register' class="bd-dark-2 pd-1 bd-round-3">
            @csrfgen
            @request(default)
            <div class='form-line mgy-3'>
                <label for='name' class="t-first-upper">{{ lang('register_name_field') }} ({{ lang('register_name_addit_info') }})</label>
                <input required class='width-100 input-dark pd-2' type='text' name='name' id='name'>
            </div>
            
            <div class='form-line mgy-3'>
                <label for='email' class="t-first-upper">{{ lang('register_email_field') }}</label>
                <input autocomplete="off" required class='width-100 input-dark pd-2' type='text' name='email' id='email'>
            </div>
            
            <div class='form-line mgy-3'>
                <label for='password1' class="t-first-upper">{{ lang('register_password1_field') }}</label><br>
                <input required class='width-75 width-100-xsm input-dark pd-2' type='password' name='password1' id='password1'>
            </div>
            
            <div class='form-line input-labeled input-labeled-basic mgy-3'>
                <label for='password2' class="t-first-upper">{{ lang('register_password2_field') }}</label><br>
                <input required class='width-75 width-100-xsm' type='password' name='password2' id='password2'>
            </div>
            
            <div class="form-line mgy-2 content-center-xsm mgy-3">
                <label for="gender" class="t-first-upper">{{ lang('register_gender_field') }}: </label>
                <select name="gender" class='mgx-2 background-dark bd-1 pd-2'>
                    <option class="background-dark-2 pd-2" value="man" selected>{{ lang('register_gender_man_option') }}</option>
                    <option class="background-dark-2 pd-2" value="woman">{{ lang('register_gender_woman_option') }}</option>
                </select>
            </div>
            
            <div class='form-line mgy-5 content-center-xsm'>
                <label for="antispam" class="t-first-upper">{{ lang('register_antispam_field') }} ({{ lang('register_antispam_hint_field') }}): </label>
                <input required class='width-30 width-50-xsm input-dark pd-2' type='number' name='antispam' id='antispam'>
            </div>
            
            <div class="form-line content-center-xsm">
                <span type="button" redirect="auth/register-rules" class="t-warning t-bolder cursor-point t-light-hover">{{ lang('register_condition_href') }}</span>
            </div>
            
            <div class="form-line content-center-xsm mgy-2 pd-2 background-dark-2 bd-round-3">
                <label for="conditions">{{ lang('register_condition_field') }}?</label>
                <select class="background-dark bd-1 pd-2 mgx-2 width-50-sm content-center-sm mgy-2-sm" name="confirmed">
                    <option class="background-dark-2 pd-2" value="confirmed">Ano</option>
                    <option class="background-dark-2 pd-2" value="0" selected>Ne</option>
                </select>
            </div>
            
            <div class="form-line content-center-xsm">
                <button class='button-large button-warning bd-round-symetric width-100-sm' type='submit'><i class="fa fa-user-plus"></i> Zaregistrovat</button>
                <button type='button' redirect="auth/login" class='button-large button-bd-error bd-round-symetric width-100-sm'><i class="fa fa-close"></i></button>
            </div>
        </form>
    </div>   
    <div class="column"></div>
</div>