<!-- 
    # PETR PROKEŠ - Homepage by @MiroJi
    # Content started at 08-12-2022 by @MiroJi
    # Graphic draft by @KareVel
    # Design by @KateZa
-->

<div class="content-center">
    
    <!-- MAIN Brand Image -->
    <img class="height-512p height-256p-xsm height-256p-sm" src="<?php echo modasset('img/main_logo.webp') ?>">
</div>

<!-- Button enter news -->
<div class="content-center pdy-2">
    <button redirect="zos/app/news-board" class="button-large pdx-6 button-action bd-round-symetric bd-none cursor-point" > Novinky </button>
</div>

<div class="t-bold content-center pdy-5">
    <div class="header-1">Petr Prokeš</div>
    <div class="row-center cols-7 cols-1-xsm cols-3-sm cols-5-md pdy-2-xsm pdy-2-sm">
        <div class="column pd-1">
            <i class="fa fa-phone mgx-1"></i> 123 456 789
        </div>
        <div class="column pd-1">
            <i class="fa fa-envelope mgx-1"></i> petrprokes@seznam.cz
        </div>
        <div class="column pd-1">
            <i class="fa fa-facebook mgx-1"></i> petrprokes-fb.cz
        </div>
    </div>
</div>

<p class="display-0 display-1-xsm bd-top-warning pdy-2 bd-1"></p>

<!-- ROW Columns 5 -> new column starts at center -->
<div class="row-center cols-5 cols-1-xsm cols-3-sm cols-3-md">

    <!-- First column -> template copy -->
    <div id="homepage-column" redirect="zos/app/services" class="column-shrink pd-1 content-center transparent-50-hover scale-11-hover cursor-point anim-all-fast">

        <!-- Image -->
        <div id="h-column-block" class=" pd-1 ">
            <img src="<?php echo modasset('img/poskytovane-sluzby.png') ?>">
        </div>

        <!-- Title -->
        <div class="header-4 t-upper pdy-1">
            poskytované služby
        </div>

        <div class="t-italic">
            odchytové služby a služby první pomoci.
        </div>

    </div>

    <!-- Second column ZÁCHRANNÁ STANICE PRO PSY -->
    <div copy-attr="homepage-column:class" redirect="zos/app/station">
        <div copy-attr="h-column-block:class">
            <!-- Image -->
            <div id="h-column-block" class=" pd-1 ">
                <img src="<?php echo modasset('img/zachytna-stanice-pro-psy.png') ?>">
            </div>

            <!-- Title -->
            <div class="header-4 t-upper pdy-1">
                ZÁCHRANNÁ STANICE PRO PSY
            </div>

            <div class="t-italic">
                jsou zde po přechodnou dobu ubytováni odchycení psi ze smluvních obcí a psi, kteří vyžadují náročnější péči.
            </div>
        </div>
    </div>

    <!-- Third column -->
    <div copy-attr="homepage-column:class" redirect="zos/app/dog-emergency">
        <div copy-attr="h-column-block:class">
            <!-- Image -->
            <div id="h-column-block" class=" pd-1 ">
                <img src="<?php echo modasset('img/zachranka-pro-zvirata.png') ?>">
            </div>

            <!-- Title -->
            <div class="header-4 t-upper pdy-1">
            ZÁCHRANKA PRO ZVÍŘATA, z.s.
            </div>

            <div class="t-italic">
                jsou zde po přechodnou dobu ubytováni odchycení psi ze smluvních obcí a psi, kteří vyžadují náročnější péči.
            </div>
        </div>
    </div>
</div>

