<!-- Categories block -->
<div class="">
    <div class="pd-2">
        <button redirect="forum" class="button-circle width-32p height-32p bd-none" style="background-color: {{ $style['second_color'] }}"><i class="fa fa-chevron-left"></i></button>
    </div>
    <div class="row pd-1" style="background-color: {{ $style['main_color'] }}">
        <div class="column-6">
            <div class="header-6 t-bold pdy-1" style="color: {{ $style['text_main_color'] }}">
                <i class="{{ $category['icon'] }}"></i> {{$category["name"]}}
            </div>
            <div class="t-italic" style="color: {{ $style['text_main_color'] }}">
                {{$category["_content"]}}
            </div>
        </div>
        <div class="column">
            <div class="row-reverse cols-auto">
                @auth admin @
                <div class="column-shrink">
                    <button redirect="forum/category/create/{{ $theme['url'] }}"
                        class="button button-success bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
                <div class="column-shrink">
                    <button redirect="forum/theme/edit/{{ $theme['url'] }}"
                        class="button-small button-warning bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-edit"></i>
                    </button>
                </div>
                <div class="column-shrink">
                    <button redirect="forum/theme/delete/{{ $theme['url'] }}"
                        class="button-small button-error bd-solid border-round-symetric mgx-2 cursor-point">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                @endauth

                <div class="column-shrink">
                    <i class="fa fa-file"></i> <sub>({{ count($posts) }})</sub>
                </div>

            </div>


        </div>
    </div>

    <!-- USER action panel -->
    <div class="content-center pdy-2">
        @iflogged 
            <button redirect="forum/post/create/{{ $category['url'] }}" class="button bd-round-symetric" style="background-color: {{ $style['second_color'] }}; border-color: {{ $style['second_color'] }};"><i class="fa fa-plus-circle"></i> Nové vlákno</button>
        @endif
    </div>


    <!-- Button viewers -->
    <div class="content-right pdy-4">
    <button id="button-great" event-toggle-class="click:button-dark:button-success:#button-great"
        onClick="$('.post-success').slideToggle(200)" class="button button-success bd-round-3"><i
            class="fa fa-check"></i></button>
    <button id="button-bad" event-toggle-class="click:button-dark:button-info:#button-bad"
        onClick="$('.post-info').slideToggle(200)" class="button button-info bd-round-3"><i
            class="fa fa-question"></i></button>
</div>

    <!-- BEGIN read posts -->
    <div class="row cols-4 cols-3-md cols-1-xsm cols-2-sm">
        @foreach $posts as $post @
        @if $post["solved"] == 1 @
            @php $color = "success"; $icon = "check-circle" @
        @else
            @php $color = "info"; $icon = "question-circle" @
        @endif
        <!-- One Post block -->
        <div class="column-shrink pd-1 post-{{ $color }}">
            <div redirect="forum/post-show/{{ $post['url'] }}" class="bgr-dark-2 bd-top-{{ $color }} pd-2 bd-round-3 shift-yn-11-hover anim-shift-fast transparent-hover-75 cursor-point">
                <div class="pdy-1 content-right t-{{ $color }}"><i class="fa fa-{{ $icon }}"></i></div>
                <div class="row">
                    <div class="column-2">
                        <img class="bd-round-circle" src="{{ asset('img/avatar/'.$post['author'].'.png') }}">
                    </div>
                    <div class="column-8">
                        <div class="pdx-5 header-6-xlrg t-bolder">{{ $post["title"] }}</div>
                        <div class="pdx-5 pdy-2">
                            <div class="row cols-auto">
                                <div class="column-shrink pd-1 t-info">
                                    <i class="fa fa-comments"></i> {{ $post['comments_count'] }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>