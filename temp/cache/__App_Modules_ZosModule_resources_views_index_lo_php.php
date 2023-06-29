<!-- Zos module main template -> index -->

<nav class="row pd-2 background-zos" style="background-image: url('App/Modules/ZosModule/public/img/foots2.png'); background-blend-mode: normal; background-repeat: no-repeat; background-size: 100%">

    <!-- image brand -->
    <div class="column-1 column-10-xsm column-3-md display-0-xsm content-right-md column-center content-center">
        <img redirect="homepage-prokes" class="height-64p" src="<?php echo modasset('img/main_logo.webp', 'homepageprokes') ?>">
    </div>

    <div class="column-3 column-10-xsm display-0-xsm column-7-sm column-5-md header-5 t-bold pdy-2 pdy-0-xsm content-center-md">
        Petr Prokeš - Záchranná a odchytová služba
    </div>

    <div class="column pdy-1">

        <div class="display-0 display-1-xsm display-1-sm pdy-2 pdx-1 pdy-0-xsm pdy-0-sm header-3">
            <div class="row cols-2">
                <div class="column-8 display-0 display-1-xsm">
                    <img redirect="homepage-prokes" class="height-32p" src="<?php echo modasset('img/main_logo.webp', 'homepageprokes') ?>">
                </div>
                <div class="column-2 column-10-sm content-right">
                    <i onClick="$('#nav-menu-zos').slideToggle(200)" class="fa fa-bars"></i>
                </div>
            </div>
        </div>

        <div id="nav-menu-zos" class="display-1-lrg display-0-xsm display-0-sm">
            <div class="display-0 display-1-xsm display-1-sm display-1-md bd-top-dark-2 bd-1 subheader-3-xsm content-center pdy-1-xsm pdy-1-md mgy-2-xsm">
                Rozcestník:
            </div>
            <!-- Hrefs -->
            <div class="row cols-auto cols-1-xsm cols-2-sm content-center-xsm mgy-2-xsm">
                <div listen-url="zos/app/news" url-valid="addClass:background-dark-2" redirect="zos/app/news-board" id="zos-nav-href"
                    class="column subheader-2 content-center pdy-2 mgy-1 pdy-1-xsm pdx-1 t-bold cursor-point t-hover-light background-dark-2-hover bd-round-3 anim-all-fast">
                    Novinky
                </div>

                <div 
                    listen-url="zos/app/service" url-valid="addClass:background-dark-2" redirect="zos/app/services" copy-attr="zos-nav-href:class">
                    <span onMouseOver="
                    ;GUITable.tableFloat(
                        $('#table-services').html(),
                        $(this),
                        null,
                        {offsety: 55, theme: 'dark', classes: ' pd-3'},
                        'tablefloat-service'
                    )" >Služby<span> <i class="fa fa-chevron-down"></i>
                </div>

                <div onMouseOver="
                    ;GUITable.tableFloat(
                        $('#table-statuses').html(),
                        $(this),
                        null,
                        {offsety: 55, offsetx: 60, theme: 'dark', classes: ' pd-3'},
                        'tablefloat-statuses'
                    )"
                    listen-url="zos/app/station" url-valid="addClass:background-dark-2" redirect="zos/app/station" copy-attr="zos-nav-href:class">
                    Záchranná stanice "U přednosty Avájeka" <i class="fa fa-chevron-down"></i>
                </div>

                <div listen-url="zos/app/emergency" url-valid="addClass:background-dark-2" redirect="zos/app/emergency" copy-attr="zos-nav-href:class">
                    Záchranka pro zvířata a.s.
                </div>

                <div listen-url="zos/app/gallery" url-valid="addClass:background-dark-2" redirect="zos/app/gallery" copy-attr="zos-nav-href:class">
                    Galerie
                </div>

                <div listen-url="zos/app/about" url-valid="addClass:background-dark-2" redirect="zos/app/about-show/main" copy-attr="zos-nav-href:class">
                    O nás
                </div>
            </div>
        </div>

        <div id="table-services" class="display-0">
            <?php foreach($services as $service) : ?>
                <?php if($service["type"] == 1) : ?>
                    <a href="/zos/app/service-show/<?php echo $service['url'] ?>" class="t-light bd-2 bd-dark-2 t-warning-hover bd-left-warning-hover pdx-1 mgy-2">
                        <i class="fa fa-paw mgx-1"></i> <?php echo $service["name"] ?>
                    </a><br><br>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="content-right pd-2">
                <i onClick="$('#tablefloat-service').hide(200)" class="fa fa-chevron-up"></i>
            </div>
        </div>

        <div id="table-statuses" class="display-0">
            <?php foreach($station_statuses as $status) : ?>
                <a href="/zos/app/station-animals-show/<?php echo $status['slug'] ?>" class="t-light bd-2 bd-dark-2 t-warning-hover bd-left-warning-hover pdx-5 mgy-2">
                    <i class="fa fa-paw mgx-1"></i> <?php echo $status["name"] ?>
                </a><br><br>
            <?php endforeach; ?>

            <?php if(in_array("admin", [''])) : ?>
                <p class="bd-top-info pdy-2 t-info content-right">Admin <i class="fa fa-chevron-down"></i></p>
                <a href="/zos/app/station-statuses" class="t-light bd-2 bd-dark-2 t-warning-hover bd-left-warning-hover pdx-5 mgy-2">
                    <i class="fa fa-tag mgx-1"></i> Statusy
                </a><br><br>

                <a href="/zos/app/station-animal-create" class="t-light bd-2 bd-dark-2 t-warning-hover bd-left-warning-hover pdx-5 mgy-2">
                    <i class="fa fa-plus-circle mgx-1"></i> Nový přírustek
                </a><br><br>
            <?php endif; ?>

            <div class="content-right pd-2">
                <i onClick="$('#tablefloat-statuses').hide(200)" class="fa fa-chevron-up"></i>
            </div>
        </div>
    </div>

</nav>
<div class="mgy-3 row cols-3 cols-2-xsm">
    <div class="column content-right">
        <button redirect="zos/app/service-show/potrebuji-odchyt" id="button-zos-services-big"
            class="button button-bd-zos pdy-4 pdx-4 cursor-point width-100-xsm">Potřebuji odchyt <i
                class="fa fa-chevron-right"></i></button>
    </div>

    <div class="column content-center">
        <button redirect="zos/app/service-show/chci-pomoci" copy-attr="button-zos-services-big:class">Chci pomoci <i class="fa fa-chevron-right"></i></button>
    </div>

    <div class="column content-left">
        <button redirect="zos/app/service-show/ztrata-psa" copy-attr="button-zos-services-big:class">Ztratil se mi pes <i class="fa fa-chevron-right"></i></button>
    </div>
</div>

<div class="row mgy-2 height-70">
    <div class="column-2 column-10-xsm column-10-sm display-0-xsm display-0-sm pdy-2">
        <p class="mgy-20"></p>
        <div class="header-1 header-3-md t-bold content-center t-zos">
            Transparentní účet spolku
        </div>
        <div class="content-center mgy-3">
            <a href="https://ib.fio.cz/ib/transparent?a=2801534917&fbclid=IwAR1YJNkgdJuZ7t3Un7hQ5UoX78lvXuGMaNb7e9VNei19sZAJHcsjAjF9CVA" target="_blank">
                <img class="bd-round-3" src="<?php echo modasset('img/tr-ucet-spolku.webp') ?>">
            </a>
        </div>
    </div>

    <div class="column-6 column-10-xsm column-10-sm column-8-md pd-2">
        <div class="">
            <?php $this->zos_controll->loadView() ?>
        </div>
    </div>


    <div class="column-2 column-10-xsm column-10-sm column-10-md pdy-2 content-center">
        <p class="mgy-20"></p>
        <p class="display-0 display-1-xsm display-1-sm display-1-md pdy-2 bd-top-warning bd-1"></p>

        <div class="mgy-2">
            <form method="post" action="zos/app/find">
                <input hidden type="text" name="token" value="4a60d125a042a940144a5ed6ee43c96a24cfbf2356d1a61322931697dc488bee"> <input hidden type="text" name="SID" value="24390f181bd4a85dd3c66cdc4653f1dd">
                <input hidden type='text' name='method' value='get'>
                <div class="element-group element-group-medium">
                    <input required type="search" name="search-string" class="input-dark" placeholder="Aa...">
                    <button type="submit" class="button button-zos"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="header-2">
            Veřejná sbírka
        </div>
        <div class="t-zos header-6">
            <span class="t-underline">115 53399/2010</span> - Kouzelné číslo
        </div>
        <div class="pd-5 header-6 pdx-7">
            Toto je číslo oficiálního sbírkového účtu spolku Záchranka pro zvířata, z.s.
            Účel sbírky je pořízení materiálu, nákup odchytového vozidla (již pořízeno),
            jeho dovybavení a údržba, náklady na veterinární péči umístěných zvířat. Sbírka je řádně schválena krajským
            úřadem.
            <br><br>
            DĚKUJEME VŠEM SPŘÍZNĚNÝM DUŠÍM ZA PODPORU.
        </div>

        <div class="">
            <button class="button-large button-zos cursor-point">Pohyby na účtu</button>
        </div>

        <div class="pdy-2 display-0 display-1-xsm display-1-sm">
            <button class="button-large button-zos cursor-point">Transparentní účet spolku</button>
        </div>

        <div class="mgy-5">
            <div class="">
                <img class="mgy-2 bd-round-4 height-256p" src="<?php echo modasset('img/prokes.png') ?>">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="column-2 column-10-xsm"></div>
    <div class="column-6 column-10-xsm column-10-sm bd-top-warning bd-1 pd-2 content-center-xsm">
    <span class="t-warning">Petr Prokeš</span> - Tento web byl vytvořen pomocí frameworku <span title="LORA je nyní ve verzi 3.0 - pokud najdete chybu, napište nám na email: dxgamepro@email.cz" class="t-warning">LORA</span> 2022 - 2023 by <span class="t-warning">@MiroKa</span> |
    <?php if('' == '1') : ?>
        <button title="Odhlásit se" class="button-small button-zos bd-round-symetric" onClick="redirect('auth/logout')"><i class="fa fa-close"></i><span class='display-0-xsm'> </span></button>           
    <?php else : ?>
        <img title="Přihlásit se" redirect="auth/login" src="<?php echo modasset('img/login.png') ?>" class="mgx-2 width-64p height-64p bd-round-circle rotate-xp-30-hover anim-all-fast cursor-point">
    <?php endif; ?>
    </div>
    <div class="column-2 column-10-xsm">
        
    </div>
</div>