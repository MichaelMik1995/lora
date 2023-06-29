<div class="">
    <form method="post" action="/forum/post-update">
        @csrfgen
        @request(update)
        <input hidden type="text" name="post-url" value="{{ $post['url'] }}">
        <input hidden type="text" name="author" value="{{ $post['author'] }}">

        <div class="form-line">
            <label for="name">Název vlákna:</label><br>
            <input tabindex="1" id="name" type="text" name="title" validation="required,maxchars256" class="input-dark pd-2 width-30 width-75-xsm" value="{{ $post['title'] }}">
        </div>

        <div class="mgy-2 form-line">
            <label for="content">Obsah:</label><br>
            {{ $form }}
        </div>

        <div class="form-line">
            <button class="button button-dxgamepro"><i class="fa fa-edit"></i> Upravit</button>
        </div>
    </form>
</div>