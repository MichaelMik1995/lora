<div>
    <form method="post" action="/blog/update/{{ $post['url'] }}">
        @csrfgen
        @request(update)

        <div class="form-line">
            <label for="title">Název: </label><br>
            <input type="text" name="title" id="title" value="{{ $post['title'] }}" class="input-dark pd-2 width-30">
        </div>

        <div class="form-line">
            <label for="content">Obsah: </label><br>
            <div etext-event="load" etext-options="{'debug':'false'}" id="content" etext-options="{'name':'content'}">{{ $post['content'] }}</div>
        </div>

        <div class="form-line">
            <button class="button button-info"><i class="fa fa-check-circle"></i> Uložit</button>
        </div>
    </form>
</div>