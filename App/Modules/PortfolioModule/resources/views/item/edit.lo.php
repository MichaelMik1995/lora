<div class="content-center header-2 t-bold pdy-2">
    Upravit předmět: {{ $item["title"] }}
</div>
<hr>

<div class="pd-4">
    <form method="post" action="/portfolio/item-update/{{ $item['url'] }}" enctype="multipart/form-data">
        @csrfgen
        @request(update)

        <input hidden type="text" name="item-url" value="{{ $item['url'] }}">

        <div class="form-line">
            <input type="text" name="title" value="{{ $item["title"] }}"
                class="bd-none background-none t-light header-1 header-4-xsm width-50 width-100-xsm"
                placeholder="Zadejte název">
        </div>

        <div class="form-line">
            <input type="text" name="short-description" value="{{ $item["short_description"] }}"
                class="bd-none background-none t-light header-5 header-6-xsm width-100" placeholder="Krátký popis">
        </div>

        <div class="form-line">
            <div class="row">
                <div class="column-3 column-10-xsm">
                    <label for="images">Přidat obrázky</label><br>
                    <input type="file" multiple name="images[]" class="input-dark">
                </div>
            
                <div class="column-7 column-10-xsm">
                <label>Obrázky: </label><br>
                <div class="row cols-5 cols-2-xsm">
                    @foreach glob("./App/Modules/PortfolioModule/public/img/item/".$item['url']."/image/thumb/*") as
                    $image @
                    @php $image_name =
                    str_replace("./App/Modules/PortfolioModule/public/img/item/".$item['url']."/image/thumb/", "",
                    $image) @
                    @php $img = explode(".",$image_name) @
                    @php $redirect_image = $img[0]."_".$img[1] @


                    <div id="{{ $img[0] }}" class="column pd-2">
                        <div class="background-dark-3 bd-round-3 bd-dark pd-2 content-center">
                            <img class="height-128p height-64p-xsm bd-round-3 scale-11-hover anim-all-fast" rel="easySlider"
                                src="{{ $image }}"><br><br>
                            <button
                                onClick="removeImage('{{ $redirect_image }}', '{{ $item['url'] }}', '#{{ $img[0] }}')"
                                type="button" class="button-circle width-32p height-32p button-error"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>


                    @endforeach
                </div>
            </div>

        </div>

        <div class="form-line">
            {{ $form }}
        </div>

        <div class="form-line">
            <select name="category" class="pd-3 width-30 width-50-xsm bd-1 bd-round-3">
                @foreach $types as $type @
                <optgroup label="{{ $type['title'] }}">
                    @foreach $type["categories"] as $category @
                    <option value="{{ $category['url'] }}" @if $category["url"]==$item["category_url"] @ selected
                        @endif>{{ $category['title'] }}</option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>

        <div class="form-line">
            <button class="button button-dark bd-round-symetric"><i class="fa fa-save"></i> Uložit</button>
        </div>

        <form>


</div>

<script>
    function removeImage(image_name, url, column) 
    {
        var posting = $.post("/portfolio/item-remove-image", {
            image_name: image_name,
            url: url,
            token: "{{ $_SESSION['token'] }}",
            method: "delete",
        });

        posting.always((data) => { console.log(data) });

        posting.done(() => { $(column).remove(); });

    }
</script>