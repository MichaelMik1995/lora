<div class="row">
    <div class="display-flex column-5 column-10-xsm content-center ali-center column-justify-center">
        <img rel="easySlider" class="width-95 width-100-xsm " src="./public/upload/images/{{ $picture['filename'] }}.{{$picture['file_extension']}}">
    </div>
    <div class="column-5 column-10-xsm mgy-2-xsm">
        <table rules="none" class="table table-medium">
            <tr class="t-bolder header-6 bgr-dark-2">
                <td>Parametr</td>
                <td>Hodnota</td>
            </tr>
            <tr>
                <td>Název souboru:</td>
                <td>{{ $picture['filename'] }}.{{ $picture['file_extension'] }}</td>
            </tr>
            <tr>
                <td>Název souboru:</td>
                <td>{{ $picture['filename'] }}.{{ $picture['file_extension'] }}</td>
            </tr>
            <tr>
                <td>Velikost souboru:</td>
                <td>{{ $picture['filesize'] }}</td>
            </tr>
            <tr>
                <td>typ MIME:</td>
                <td>{{ $picture['filetype'] }}</td>
            </tr>
            <tr>
                <td>Rozlišení:</td>
                <td>{{ $picture['width'] }} x {{ $picture['height'] }}</td>
            </tr>

            @if !empty($picture['exifdata']) @
            <tr class='bgr-dark-2'>
                <td>EXIF data:</td>
                <td>
                    @foreach $picture['exifdata'] as $key => $value @
                        <span class='t-bolder'>{{ $key }}</span> = @if is_array($value) @ {{ print_r($value) }} @else {{ $value }} @endif<br>
                    @endforeach
                </td>
            </tr>
            @endif
        </table>

        <!-- Alternative text (SEO) -->
        <div class="form-line mgy-2">
            <label for="alt-text" class="t-bolder">Alternativní text:</label><br>
            <form method="post" action="/admin/app/picture-update-alt/{{ $picture['filename'] }}">
                @csrfgen
                @request(get)
                <input type="hidden" name="picture_name" value="{{ $picture['filename'] }}">
                <textarea id="alt-text" name="alt_text" class="input-dark pd-2 width-50 width-100-xsm v-resy height-10" placeholder="Aa ..." validation="required,maxchars256">{{ $picture["alt_text"] }}</textarea>
                <div class="pd-1" valid-for="#alt-text"></div>
                <button class="button button-info">Uložit</button>
            </form>
        </div>
    </div>
</div>