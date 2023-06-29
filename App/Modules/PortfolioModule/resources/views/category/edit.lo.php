<div class="content-center header-2 t-bold pdy-2">
    Úprava kategorie: {{ $category['title'] }}
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/category-update" enctype="multipart/form-data">
        @csrfgen
        @request(update)

        <input hidden type="text" name="url" value="{{ $category['url'] }}">
        <div class="form-line">
            <input type="text" name="title" class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm" placeholder="Zadejte název" value="{{ $category['title'] }}">
        </div>

        <div class="form-line">
            <input autocomplete="off" type="text" name="description" class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis" value="{{ $category['description'] }}">
        </div>

        <div class="form-line">
            <select name="type" class="pd-3 width-30 width-50-xsm bd-1 bd-round-3">
                @foreach $types as $type @
                    <option value="{{ $type['url'] }}"
                    @if $category["portfolio_type"] == $type["url"] @
                    selected class="t-basic t-bold"
                    @endif
                    >{{ $type['title'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-line">

        @if file_exists("./App/Modules/PortfolioModule/public/img/category/".$category['url']."/image/thumb/main.png") @
            @php $image = "./App/Modules/PortfolioModule/public/img/category/".$category['url']."/image/thumb/main.png" @
        @else
            @php $image = "./public/img/noimage.png" @
        @endif

        <div>
            <img class="height-256p" src="{{ $image }}">
        </div>

            <label for="image">Změnit náhledový obrázek: </label><br>
            <input id="image" type="file" name="image" class="input-dark">
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-save"></i> Uložit</button>
        </div>

    <form>
</div>