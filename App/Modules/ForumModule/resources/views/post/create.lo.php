<div class="">
    <form method="post" action="/forum/post/insert" enctype="multipart/form-data">
        @csrfgen
        @request(insert)
        <input hidden type="text" name="theme-url" value="{{ $theme_url }}">
        <input hidden type="text" name="category-url" value="{{ $category_url }}">

        <div class="form-line">
            <label for="name">Název vlákna:</label><br>
            <input tabindex="1" id="name" type="text" name="name" validation="required,maxchars256" class="input-dark pd-2 width-30 width-75-xsm">
        </div>

        <div class="form-line">
            <fieldset class="width-30 width-100-xsm bgr-dark-2">
                <legend>Vlákno pro:</legend>
                <div class="bgr-dark-2 pd-2">
                    Téma: <b>{{ $theme_name }}</b> > Kategorie: <b>{{ $category_name }}</b>
                </div>
            </fieldset>
        </div>

        <div class="mgy-2 form-line">
            <label for="content">Obsah:</label><br>
            {{ $form }}
        </div>

        <div class="form-line">
            <button class="button button-dxgamepro"><i class="fa fa-plus-circle"></i> Vložit</button>
        </div>
    </form>
</div>