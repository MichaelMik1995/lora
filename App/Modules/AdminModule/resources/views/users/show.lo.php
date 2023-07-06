<div class="pd-1">

    <!-- HEADER Colored -->
    <div class="bgr-dark-2 bd-dark bd-1 content-center pdy-2"> 
        <div>
            <img alt="profile-picture128-{{ $user['uid'] }}" class="height-128p" src="{{ asset('img/avatar/128/'.$user['uid'].'.png') }}">
        </div>
        <div>
            <form method="post" action="/admin/app/user-change-profile-image/{{ $user['uid'] }}" enctype="multipart/form-data">
                @csrfgen
                @request(update)

                <div class="form-line">
                    <input type="file" name="avatar" id="avatar" class="input-dark pd-2"><br>
                    <button type="submit" class="button button-info">Změnit obrázek</button>
                </div>
            </form> 
        </div>
        <div class="pdy-2 header-4 t-bolder">
            {{ $user['name'] }}
        </div>
    </div>

    <!-- USER DATA INFO -->
    <div>
        <table rules="none" class="mgy-3 table table-medium">
            <tr class="bgr-dark-2 t-bolder">
                <td>Parametr</td>
                <td>Hodnota</td>
            </tr>

            <tr>
                <td>Jméno: </td>
                <td>{{ is_empty($user['real_name'], 'Nevyplněno') }}</td>
            </tr>

            <tr>
                <td>Přijmení: </td>
                <td>{{ is_empty($user['surname'], 'Nevyplněno') }}</td>
            </tr>

            <tr>
                <td>Email: </td>
                <td>{{ $user['email'] }}</td>
            </tr>

            <tr class='t-info'>
                <td>Datum registrace: </td>
                <td>{{ real_date($user['registration_date']) }}</td>
            </tr>

            <tr class='t-info'>
                <td>Poslední přihlášení: </td>
                <td>{{ real_date($user['last_login']) }}</td>
            </tr>
        </table>
    </div>

    <div class="header-3 pdy-1">
        Akce
    </div>
    <!-- USER Actions -->
    <div class="row cols-auto col-space-2">
        <div class='column-shrink'>
            @if $user['is_admin'] == true @
            <button title="Povýšit na admina" class='button button-bd-info'><i class="fa fa-unlock" aria-label="Povýšit na admina"></i>Povýšit na admina</button>
            @else
            <button title="Zrušit admina" class='button button-info' aria-label="Odebrat admina"><i class="fa fa-lock"></i> Odebrat admina</button>
            @endif
        </div>
        
        <div class="column-shrink">
            <button title="Resetovat heslo" class="button button-info" aria-label="Resetovat heslo"><i class="fa fa-key"></i> Resetovat heslo</button>
        </div>

        @if $user['email_verified_at'] <= 0 @
        <div class="column-shrink">
            <button redirect="admin/app/user-verify/{{ $user['uid'] }}" title="Ověřit uživatele" class="button button-info" aria-label="Ověřit uživatele"><i class="fa fa-check-circle"></i> Ověřit uživatele</button>
        </div>
        @endif

        <div class="column-shrink">
            <button title="Smazat uživatele" class="button button-bd-error" aria-label="Smazat uživatele"><i class="fa fa-trash"></i> Smazat uživatele</button>
        </div>
    </div>
</div>