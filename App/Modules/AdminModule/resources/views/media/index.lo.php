<div class="content-center mgy-1">
    <form method="post" action="/admin/app/media-pictures-insert" enctype="multipart/form-data">
        @csrfgen
        @request(get)

        <input type="file" multiple name="images[]" class="input-dark pd-2">
        <button type="submit" class="button button-info"><i class="fa fa-plus-circle"></i> Přidat obrázek/ky</button>
    </form>
</div>

<hr>

<div class="row row-center-lrg row-center-xsm cols-auto cols-2-xsm">
    @foreach glob("./App/Modules/AdminModule/resources/img/user/".$user_uid."/thumb/*") as $image @
        @php $image_full_name = str_replace("./App/Modules/AdminModule/resources/img/user/".$user_uid."/thumb/", "", $image) @
        @php $image_exploded = explode(".", $image_full_name); $image_name = $image_exploded[0]; $image_ext = $image_exploded[1] @
        
        @if file_exists("./App/Modules/AdminModule/resources/img/user/".$user_uid."/$image_name.txt") @
            @php $image_alt_text = $text_parser->parse("./App/Modules/AdminModule/resources/img/user/".$user_uid."/$image_name.txt")->get("alt") @
        @else
            @php $image_alt_text = $image_name @
        @endif
            <div class="column-shrink pd-2">
                <div class="bgr-dark-2 pd-2">
                    <div class='content-center'>
                        <img title="{{ $image_alt_text }}" id="admin-image-{{ $image_name }}" src="{{ $image }}" alt="{{ $image_alt_text }}" rel="easySlider" loading="lazy" class="bd-round-3 height-128p">
                    </div>
                    <div class="content-right content-center-xsm pd-1 header-6">
                        <i redirect="admin/app/media-picture-show/{{ $image_name }}@{{ $image_ext }}" class="fa fa-eye mgx-1 cursor-point"></i>
                        <i redirect="admin/app/media-pictures-delete/{{ $image_name }}@{{ $image_ext }}" class="fa fa-trash mgx-1 t-error cursor-point"></i>
                    </div>
                </div>
            </div>
    @endforeach
</div>