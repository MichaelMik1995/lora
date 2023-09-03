<div class="content-center mgy-1">
    <form method="post" action="/user/app/gallery-images-insert" enctype="multipart/form-data">
        @csrfgen
        @request(get)

        <input type="file" multiple name="images[]" class="input-dark pd-2">
        <button type="submit" class="button button-info"><i class="fa fa-plus-circle"></i> Přidat obrázek/ky</button>
    </form>
</div>

<hr>

<div class="content-center pdy-2 header-5">
    <span class="t-info t-bolder">{{ $folder_data["count"] }}/{{ env("max_uploaded_images") }}</span> obrázků | <span class="t-info t-bolder">{{ $folder_data["folder_size"] }}</span> prostoru
</div>

<div class="row row-center-lrg row-center-xlrg row-center-xsm cols-auto">
    @foreach $gallery as $image @
        @php $image_full_name = str_replace("./content/uploads/$upload_folder/images/thumb/", "", $image) @
        @php $image_exploded = explode(".", $image_full_name); $image_name = $image_exploded[0]; $image_ext = $image_exploded[1] @
        
        @if file_exists("./content/uploads/$upload_folder/images/$image_name.txt") @
            @php $image_alt_text = $text_parser->parse("./content/uploads/$upload_folder/images/$image_name.txt")->get("alt") @
        @else
            @php $image_alt_text = $image_name @
        @endif

            <div class="column-shrink pd-2">
                <div class="bgr-dark-2 bd-round-4 bd-dark pd-1">
                    <div class="subheader-4 content-center pdy-1">{{ $image_name }}.{{ $image_ext }}</div>
                    <div class='content-center'>
                        <img title="{{ $image_alt_text }}" id="admin-image-{{ $image_name }}" src="{{ $image }}" alt="{{ $image_alt_text }}" rel="easySlider" loading="lazy" class="bd-round-3 height-128p">
                    </div>
                    <div class="content-right content-center-xsm pd-1 header-6">
                        <i redirect="user/app/gallery-picture-show/{{ $image_name }}@{{ $image_ext }}" class="fa fa-eye mgx-1 cursor-point"></i>
                        <i redirect="user/app/gallery-picture-delete/{{ $image_name }}@{{ $image_ext }}" class="fa fa-trash mgx-1 t-error cursor-point"></i>
                    </div>
                </div>
            </div>
    @endforeach
</div>