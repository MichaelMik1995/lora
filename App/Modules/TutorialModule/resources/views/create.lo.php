<div class="pd-2">
    <form method="post" action="tutorial/insert">
        @csrfgen
        @method insert @

        <div class="form-line">
            <label for="title">Název návodu</label><br>
            <input id="title" type="text" name="title" class="width-30 width-50-xsm" validation="required,maxchars512">
            <div valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="tags">Tagy</label><br>
            <input autocomplete="off" list="tag-list" id="tags" type="text" name="tags" class="width-30 width-50-xsm" validation="maxchars512" placeholder="Vložit/Vytvořit tag">
            <div valid-for="#tags"></div>

            <datalist id="tag-list">
                @foreach $tags as $tag @
                    <option value="{{ $tag }}">
                @endforeach
            </datalist>
        </div>

        <div class="form-line">
            <label title="Stručný popis zobrazující se v návodech" for="short-content">Krátký popis</label><br>
            <textarea id="short-content" name="short-content" class="width-50 height-128p v-resy"></textarea>
        </div>

        <div class="form-line">
            {{ $form }}
        </div>
        
    </form>
</div>