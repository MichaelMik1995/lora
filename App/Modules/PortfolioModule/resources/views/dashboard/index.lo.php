<div class="pdy-3 ">
    <div class="element-group element-group-medium">
        <button redirect="portfolio" class="button button-dark"><i class="fa fa-home"></i> Hlavní <i class="fa fa-chevron-right"></i></button>
    </div>    
</div>

<div class="pd-2 header-1 content-center t-bold">
    Portfolio
</div>


<div class="">
    <div class="row-center cols-auto">

        <!-- ADMIN -->
        @auth admin @
        <div class="column-shrink column-10-xsm pd-2">
            <button redirect="portfolio/type-create" class="button-large background-dxgamepro bd-none background-light-3-hover t-dark-hover bd-round-symetric pdx-5 pdy-2"><i class="fa fa-plus-circle"></i> Nový</button>
        </div>
        @endauth

        <div class="column-shrink pd-2">
            <button redirect="portfolio/types/all" class="button-large background-dark bd-none background-light-3-hover t-dark-hover bd-round-symetric pdx-5 pdy-2">Vše</button>
        </div>

        @foreach $types as $type @
        <div title="{{ $type['description'] }}" class="column-shrink pd-2">
            <button id="button-type-{{ $type['url'] }}" redirect="portfolio/types/{{ $type['url'] }}" style="border-width: 0 0 2px 0; border-color: {{ $type['color'] }}; color: {{ $type['color'] }}" class="button-large button-dark t-bold pdx-5 pdy-2" >{{ $type["title"] }}</button>
        </div>
        @endforeach
    </div>
</div>

<div class="content-center header-2 t-bold pdy-2 mgy-1 bgr-dark-3">Nejnovější příspěvky: </div>

@if !empty($items) @
        <div class="row-center cols-5 cols-1-xsm cols-2-sm cols-3-md">
            @foreach $items as $item @
            <div class="column-shrink pd-3 pd-1-xsm">
                <div redirect="portfolio/item/{{ $item['url'] }}" id="portfolio-item-{{ $item['url'] }}" class="background-dark-2 bd-dark pd-1 bd-round-3 bd-1 anim-all-normal cursor-point">
                    <div class="content-center header-4 pdy-1">
                        {{ $item["title"] }}
                    </div>
                    <div class="content-center">
                    @if file_exists("./App/Modules/PortfolioModule/public/img/category/".$item['category_url']."/image/thumb/main.png") @
                        @php $image = "./App/Modules/PortfolioModule/public/img/category/".$item['category_url']."/image/thumb/main.png" @
                    @else
                        @php $image = "./public/img/noimage.png" @
                    @endif

                        <img src="{{ $image }}" class="height-256p height-128p-xsm">
                    </div>

                    <div class="pdy-2 content-center">
                            <i class="fa fa-star t-warning"></i> {{ $item["evaluation_average"] }}
                            <span class="mgx-1"></span>
                            <i class="fa fa-comments"></i> {{ $item["count_comments"] }}
                        </div>

                    <div id="short-desc-{{ $item['url'] }}" class="content-center pd-1 display-0">
                        <div>{{ $item["short_description"] }}</div>
                        
                    </div>
                </div>
            </div>

            <script>
                $("#portfolio-item-{{ $item['url'] }}").hover(() => {
                    $("#short-desc-{{ $item['url'] }}").slideDown(200);
                }, () => {
                    $("#short-desc-{{ $item['url'] }}").slideUp(200);
                });
            </script>
            @endforeach
        </div>
    @else
        <div class="header-3 t-error pdy-3 content-center">Prozatím zde nic nemáme</div>
    @endif