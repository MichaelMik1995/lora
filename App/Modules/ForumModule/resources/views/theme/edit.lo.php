<div class="pd-2">
    <div class="header-5 pdy-2">Upravit téma:</div>

    <form method="post" action="forum/theme-update">
        @csrfgen
        @request(update)

        <input hidden name="url" value="{{ $theme['url'] }}">
        <div class="form-line">
            <label for="title" class="form-label">Název</label><br>
            <input required validation="required,maxchars256" id="title" type="text" name="title" class="input-dark width-50 width-100-xsm" value="{{ $theme['name'] }}">
            <div valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="icon" class="form-label">Ikona</label><br>
            <input required validation="required,maxchars128" id="icon" type="text" name="icon" class="input-dark width-20 width-50-xsm" value="{{ $theme['icon'] }}">
        </div>

        <div class="form-line">
            <label for="description" class="form-label">Popis</label><br>
            {{$form}}
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-3"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>