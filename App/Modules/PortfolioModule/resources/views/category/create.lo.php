<div class="content-center header-2 t-bold pdy-2">
    Nová Kategorie:
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/category-insert" enctype="multipart/form-data">
        @csrfgen
        @request(insert)

        <div class="form-line">
            <input type="text" name="title" class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm" placeholder="Zadejte název">
        </div>

        <div class="form-line">
            <input autocomplete="off" type="text" name="description" class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis">
        </div>

        <div class="form-line">
            <select name="type" class="pd-3 width-30 width-50-xsm bd-1 bd-round-3">

            {{$portfolio_type}}
                @foreach $types as $type @
                    <option value="{{ $type['url'] }}"
                    @if $portfolio_type == $type["url"] @
                    selected class="t-basic t-bold"
                    @endif
                    >{{ $type['title'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-line">
            <label for="image">Náhledový obrázek: </label><br>
            <input id="image" type="file" name="image" class="input-dark">
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>

    <form>
</div>