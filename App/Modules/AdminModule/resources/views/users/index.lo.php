<div class="pd-2">
    <details>
        <summary class="header-6 pdx-2">Nový uživatel: </summary>


        <div class="bgr-dark-2 pd-2">
            <form method="post" action="/admin/app/user-create">
                @csrfgen
                @request(insert)

                <div class="mgy-2">
                    <label for="user-name" class="t-first-upper">{{ lang('user_name') }}</label><br>
                    <input required type="text" id="user-name" name="user-name" class="input-dark pd-2 width-15 width-75-xsm" validation="required,maxchars64">
                    <div class="pd-1" valid-for="#user-name"></div>
                </div>

                <div class="row width-30 width-100-xsm">
                    <div class="column-5">
                        <label for="user-real-name" class="t-first-upper">{{ lang('user_real_name') }}</label><br>
                        <input 
                            type="text" 
                            id="user-real-name" 
                            name="user-real-name" 
                            class="input-dark pd-2 width-100" 
                            validation="required,maxchars64"
                            placeholder="{{ lang('placeholder_real_name') }}"
                        >
                        <div class="pd-1" valid-for="#user-real-name"></div>
                    </div>
                    <div class="column-5">
                        <label for="user-surname" class="t-first-upper">{{ lang('user_surname') }}</label><br>
                        <input 
                            type="text" 
                            id="user-surname" 
                            name="user-surname" 
                            class="input-dark pd-2 width-100" 
                            validation="required,maxchars64"
                            placeholder="{{ lang('placeholder_real_surname') }}"
                        >
                        <div class="pd-1" valid-for="#user-surname"></div>
                    </div>
                </div>

                <div class="mgy-2">
                    <label for="user-email" class="t-first-upper">{{ lang('user_email') }}</label><br>
                    <input required type="email" id="user-email" name="user-email" class="input-dark pd-2 width-30 width-75-xsm" validation="required,maxchars64,email" placeholder="example@gmail.com">
                    <div class="pd-1" valid-for="#user-email"></div>
                </div>

                <div class="mgy-2">
                    <label for="user-password" class="t-first-upper">{{ lang('user_password') }}</label><br>
                    <input type="text" id="user-password" name="user-password" class="input-dark pd-2 width-30 width-75-xsm" value="{{ $password }}">
                </div>
                
                <div class="mgy-2">
                    <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Přidat</button>
                </div>
            </form>
        </div>
    </details>
</div>

<div class="row cols-6 cols-2-xsm">
    @if !empty($users) @
        @foreach $users as $user @
        <div class="column-shrink pd-2">
            @if $user['is_admin'] == true @
                @php $border = "info" @
            @else
                @php $border = "dark-2" @
            @endif
            <div class="bgr-dark-2 pd-1 bd-top-{{ $border }} bd-3">
                <div class="content-center">
                    <img class="height-128p" src="{{ asset('img/avatar/128/'.$user['uid'].'.png') }}" alt="admin-user-card-{{ $user['uid'] }}">
                </div>
                <div id="{{ $user['uid'] }}" class="content-center pdy-2">
                    <div class="t-bolder t-info">{{ $user["name"] }}</div>
                    <div class="subheader-3">{{ $user['uid'] }}</div>
                </div>
                <div class="row header-6">
                    <div class="column">
                        @if $user['is_admin'] == true @
                            <i title="Uživatel je administrátor webu" class="fa fa-lock t-info pd-1"></i>
                        @else
                            <i title="Uživatel je běžným členem" class="fa fa-unlock pd-1"></i>
                        @endif
                        <i redirect="admin/app/user-show/{{ $user['uid'] }}" class="fa fa-info-circle t-info-hover cursor-point bgr-dark-3-hover bd-round-3 pd-1"></i>     
                        
                    </div>
                    <div class="column content-right">
                        @if $user['email_verified_at'] > 0 @
                            <i title="Uživatel ověřen dne: {{ DATE('d.m.Y H:i:s', $user['email_verified_at']) }}" class="fa fa-check-circle t-success pd-1"></i>
                        @else
                            <i redirect="admin/app/user-verify/{{ $user['uid'] }}" class="fa fa-close t-error pd-1"></i>
                        @endif
                    </div>
                </div>
            </div>   
        </div>
        @endforeach
    @else
    <div class="t-error">Nebyl nalezen žádný uživatel</div>
    @endif
</div>
