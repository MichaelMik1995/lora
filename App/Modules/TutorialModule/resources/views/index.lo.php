@auth admin @
    <div class="pdx-2 pdy-1">
        <button redirect="tutorial/create" class="button button-create bd-round-symetric"><i class="fa fa-plus-circle"></i> Vytvořit</button>
    </div>
@endauth

<div class="row cols-3 cols-1-xsm">
    @foreach $tutorials as $tutorial @
        <div class="column-shrink pd-2">
            <div class="background-dark-2 pdy-1 pdx-2 bd-round-3 ">
                <div redirect="tutorial/show/{{ $tutorial['url'] }}" class="transparent-hover-75 cursor-point">
                    <div class="header-6 t-bold">{{ $tutorial["title"] }}</div>
                    <div class="t-italic">
                        {{ $tutorial["short_content"] }}
                    </div>
                </div>
                <div class="subheader-2">
                    <div class="row cols-auto">
                        @foreach $tutorial[":tags"] as $tag @
                            <div class="column-shrink pd-1">
                                <div class="background-bd-warning pdy-1 pdx-2 bd-round-symetric background-warning-hover t-hover-dark-2 cursor-point">
                                    #{{ $tag }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>