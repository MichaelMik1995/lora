<div class="pd-2">
    <form method="post" action="/documentation/update">
        @csrfgen
        @request(update)
        
        <input hidden type='text' name='url' value='{{ $documentation['url'] }}'>
        <div class="form-line">
            <label for="title" class="form-label mgx-1">{{ lang("blog_title") }}</label><br>
            <input id="title" name="title" type="text" class="input-dark pd-2 width-50 width-100-xsm" validation="required,maxchars128" placeholder="Aa..." value="{{ $documentation["title"] }}">
            <div class="pd-1" valid-for="#title"></div>
        </div>
        
        <div class="row cols-auto width-50 width-100-xsm">
            <div class="column form-line">
                <label for="version" class="form-label mgx-1">{{ lang("documentation_version") }}</label><br>
                <select name="version" class="input-dark pd-2 width-100">
                    <option value=""></option>
                    @foreach $versions as $version @
                    <option value="{{ $version['url'] }}" @if $version['url'] == $documentation['version'] @ selected @endif>>{{ $version["version"] }} - {{ $version["description"] }}</option>
                    @endforeach
                </select>
                <div class="pdy-1 pdx-3">
                    <i class="fa fa-plus-circle mgx-1"></i> <input type="text" name="add-version" class="width-80" placeholder="{{ lang("documentation_add_version") }}">
                </div>
            </div>

            <div class="column form-line">
                <label for="category" class="form-label mgx-1">{{ lang("documentation_category") }}</label><br>
                <select name="category" class="input-dark pd-2 width-100">
                    <option value=""></option>
                    @foreach $categories as $category @
                    <option value="{{ $category['url'] }}"  @if $category['url'] == $documentation['category'] @ selected @endif>{{ $category["title"] }}</option>
                    @endforeach
                </select>
                <div class="pdy-1 pdx-3">
                    <i class="fa fa-plus-circle mgx-1"></i> <input type="text" name="add-category" class="width-80" placeholder="{{ lang("documentation_add_category") }}">
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <label for="content" class="form-label mgx-1">{{ lang("blog_content") }}</label><br>
            <!-- {{ $form }} --> <div id="content" etext-event="load" etext-options="{'debug':'false'}">{{ $documentation["content"] }}</div>
        </div>
        
        <div class="form-line">
            <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> {{ lang("button_update_record") }}</button>
        </div>
    </form>
</div>


