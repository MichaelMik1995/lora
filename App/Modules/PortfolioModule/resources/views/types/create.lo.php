<div class="content-center header-2 t-bold pdy-2">
    Nové Portfolio:
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/type-insert" enctype="multipart/form-data">
        @csrfgen
        @request(insert)

        <div class="form-line">
            <label for="image">Náhledový obrázek: </label><br>
            <div class="">
                <div class="header-1 header-5-xsm content-center-xsm pdx-3 pdy-4" style="background-image: url('{{ asset('img/noimagebanner.png') }}'); background-size: 100% 100%; background-repeat: no-repeat;">
                <span class="background-dark pd-1 bd-round-3">Nové Portfolio</span>
            </div>
            </div>
        </div>

        <div class="form-line">
            <input type="text" name="title" class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm" placeholder="Zadejte název">
        </div>

        <div class="form-line">
            <input autocomplete="off" type="text" name="description" class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis">
        </div>

        <div class="form-line">
            <label for="image">Náhledový obrázek: </label><br>
            <input id="image" type="file" name="image" class="input-dark">
        </div>

        <div class="form-line content-center-xsm">
            <label for="color">Barva portfolia:</label><br>
            <input type="color" name="color" class="bd-none width-50" value="{{ $portfolio['color'] }}">
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>

    <form>
</div>