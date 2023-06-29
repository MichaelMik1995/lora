<div class="pd-2">
    <div class="header-5 pdy-2">Nová kategorie</div>

    <form method="post" action="forum/category/insert">
        @csrfgen
        @request(insert)

        <input hidden type="text" name="theme-url" value="{{ $theme_url }}">
        <div class="form-line">
            <label for="title" class="form-label">Název</label><br>
            <input required validation="required,maxchars256" id="title" type="text" name="title" class="input-dark width-50 width-100-xsm">
            <div valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="icon" class="form-label">Ikona</label><br>
            <input required validation="required,maxchars128" id="icon" type="text" name="icon" class="input-dark width-20 width-50-xsm" value="fa fa-comment">
        </div>

        <div class="form-line">
            <label for="content" class="form-label">Popis</label><br>
            {{$form}}
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>
    </form>
</div>