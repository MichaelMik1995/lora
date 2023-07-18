<!-- USER Module -->
<div class="row pd-2 pd-0-xsm">

    <!-- Left panel - menu -->
    <div content-height-auto="user-main" class="column-2 bgr-dark-2 bd-right-dark" style="flex-direction: column; min-height: 100vh">
        <div class="row bgr-dark pdy-2">  <!-- Profile photo & status -->
            <div class="column-3 content-center">
                <img class="width-64p" src="{{ asset('img/avatar/64/111111111.png') }}" alt="profile-image-admin">
            </div>
            <div class="column-7 als-center column-10-xsm display-0-xsm">
                <div class="t-bolder">{{ $user->name }} {{ $user->real_name }} </div>
                <div class="t-create">
                    <button class="button-circle width-15p height-15p button-create"></button> Online
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="mgy-2">

            <p class="mgy-4"></p> <!-- Space -->

            <!-- Button template -->
            <div template="1" id="user-menu-button">
                <div redirect="{redirect}" listen-url="user/app/{listen-url}" url-valid="addClass:t-info" class="row width header-6 pd-1 pdy-3 bgr-dark-hover cursor-point">
                    <div class="column-3 header-6 display-flex als-center content-center">
                        <i class="fa fa-{icon}"></i>
                    </div>
                    <div class="column-7 display-0-xsm">{title}<br><span class="subheader-4 t-italic">{description}</span></div>
                </div>
            </div>


            <div copy-element="user-menu-button" data="icon:dashboard,title:Přehled,redirect:user/app/dashboard,listen-url:dashboard,description:Přehled uživatele"></div>
            <div copy-element="user-menu-button" data="icon:user,title:Můj profil,redirect:user/app/user-profile,listen-url:user-profile,description:Informace o uživateli"></div>
            <div copy-element="user-menu-button" data="icon:key,title:Heslo,redirect:user/app/change-password,listen-url:change-password,description:Změnit heslo"></div>
            <div copy-element="user-menu-button" data="icon:images,title:Galerie,redirect:user/app/gallery,listen-url:gallery,description:Galerie obrázků uživatele"></div>
        </div>
    </div>

    <!-- Content panel -->
    <div content-height-auto="user-main" class="column-8">

        <!-- USER header - notification. logout -->
        <div class="bd-bottom-dark-2 pd-1">
            <div class="row">
                <div class="column"></div>
                <div class="column content-right">
                    <button class="button-circle width-32p height-32p button-info"><i class="fa fa-bell"></i></button>
                </div>
            </div>
        </div>

        <!-- Dynamic content -->
        <div class="pd-2">
            @php $this->splitter_controll->loadView(); @
        </div>
    </div>
</div>