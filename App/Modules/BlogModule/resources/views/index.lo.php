<div class="row cols-4">
    @foreach $posts as $post @
        <div class="column pd-1">
            <div class="bgr-dark-2 pdy-1 pdx-3 bd-top-dark bd-round-bottom-3 ">
                <div class="content-right header-6"><i redirect="blog/edit/{{ $post['url'] }}" class="fa fa-edit cursor-point scale-12-hover anim-all-fast"></i></div>
                <div class="header-4 pdy-2">{{ $post["title"] }}</div>
                <div etext-event="compile" class="card-text">{{ $post["content"] }}</div>
            </div>
        </div>
    @endforeach
</div>