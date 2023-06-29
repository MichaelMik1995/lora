<div class="content-center header-2 t-bold pdy-2">
    Upravit Portfolio: {{ $portfolio['title'] }}
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/type-update" enctype="multipart/form-data">
        @csrfgen
        @request(update)
        
        <input hidden type="text" name="url" value="{{ $portfolio['url'] }}">

        <div class="form-line">
            <label for="image">Náhledový obrázek: </label><br>
            <div class="">
                @if file_exists("./App/Modules/PortfolioModule/public/img/type/".$portfolio['url']."/image/main.png") @
                    @php $main = "./App/Modules/PortfolioModule/public/img/type/".$portfolio['url']."/image/main.png" @
                @else
                    @php $main = "./public/img/noimagebanner.png" @
                @endif
                <div class="header-1 header-5-xsm content-center-xsm pdx-3 pdy-4 background-dark" style="background-image: url('{{ $main }}'); background-size: 100% 100%; background-repeat: no-repeat;">
                <span class="background-dark pd-1 bd-round-3">Portfolio: {{ $portfolio['title'] }}</span>
            </div>
            </div>
        </div>
        <div class="form-line">
            <label for="image">Změnit náhledový obrázek: </label><br>
            <input id="image" type="file" name="image" class="input-dark">
        </div>

        <div class="form-line">
            <input type="text" name="title" class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm" placeholder="Zadejte název" value="{{ $portfolio['title'] }}">
        </div>

        <div class="form-line">
            <input autocomplete="off" type="text" name="description" class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis" value="{{ $portfolio['description'] }}">
        </div>

        

        

        <div class="form-line content-center-xsm">
            <label for="color">Barva portfolia:</label><br>
            <input type="color" name="color" class="bd-none width-50" value="{{ $portfolio['color'] }}">
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-plus-circle"></i> Uložit</button>
        </div>

    <form>
</div>