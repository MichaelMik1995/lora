<div class="content-center header-2 t-bold pdy-2">
    Nový předmět:
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/insert-item" enctype="multipart/form-data">
        @csrfgen
        @request(insert)
        
        <div class="form-line">
            <input type="text" name="title" class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm" placeholder="Zadejte název">
        </div>

        <div class="form-line">
            <input type="text" name="short-description" class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis">
        </div>

        <div class="form-line">
            <select name="category" class="pd-3 width-30 width-50-xsm bd-1 bd-round-3">
                @foreach $types as $type @
                    <optgroup label="{{ $type['title'] }}">
                        @foreach $type["categories"] as $category @
                            <option value="{{ $category['url'] }}" 
                            @if $category['url'] == $item_category @
                                selected
                            @endif
                             >{{ $category['title'] }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <div class="form-line">
            {{ $form }}
        </div>

        <div class="form-line">
            <label for="images">Přidat obrázky</label><br>
            <input type="file" multiple name="images[]" class="input-dark">
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>

    <form>
</div>