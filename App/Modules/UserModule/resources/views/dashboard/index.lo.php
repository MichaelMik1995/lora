<div class="row">
    <div class="column-5 pd-2">
        Dasshboard
    </div>

    <div class="column-5 pd-2">
        <div class="bgr-dark-2 bd-dark bd-round-3">
            <div class="header-5 t-bolder pdy-1 pdx-2">{{ $announcement["title"] }}</div>
            <div class="t-italic subheader-3 pdx-3"><i class="fa fa-calendar"></i> {{ real_date($announcement['updated_at']) }}</div>
            <div class="pdy-3 pdx-3">
                {{ $announcement['_content'] }}
            </div>
            <div class="pdy-2 pdx-3 bgr-dark">
                Zpráva pro: <span class="t-info">Všechny</span>
            </div>
            
        </div>
        <div class="row row-center-lrg cols-auto pdy-2 col-space-3">
            <div class="column-shrink"><i class="fa fa-circle t-dark cursor-point t-light-hover"></i></div>
            <div class="column-shrink"><i class="fa fa-circle t-dark"></i></div>
            <div class="column-shrink"><i class="fa fa-circle t-dark"></i></div>
            <div class="column-shrink"><i class="fa fa-circle t-dark"></i></div>
            <div class="column-shrink"><i class="fa fa-circle t-dark"></i></div>
            <div class="column-shrink"><i class="fa fa-circle t-dark"></i></div>
        </div>


    </div>
</div>