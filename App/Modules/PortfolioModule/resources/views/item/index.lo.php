<div class="pdy-3 ">

    <div class="element-group element-group-medium">
        <button redirect="portfolio" class="button button-dark"><i class="fa fa-home"></i> Hlavní <i class="fa fa-chevron-right"></i></button>
        <button redirect="portfolio/types/{{ $portfolio }}" class="button button-dark">{{ $portfolio_title }} <i class="fa fa-chevron-right"></i></button>
        <div class="background-dark-2 pdx-2 t-bold">{{ $category_title }}</div>
    </div>
</div>

@auth admin @
<div class="pdy-4 content-center">
    <button redirect="portfolio/create-item/{{ $category }}" class="button button-dark bd-round-symetric"><i class="fa fa-plus-circle"></i> Vytvořit</button>
    @if $category != "nezarazene"  @
            <button redirect="portfolio/category-edit/{{ $portfolio }}/{{ $category }}" class="button button-warning bd-round-symetric">Upravit</button>
            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tuto kategorii?', () => {$('#category-delete').submit()})" class="button button-error bd-round-symetric">Odstranit kategorii</button>

            <form id="category-delete" method="post" action="/portfolio/category-delete" class="display-0">
                @csrfgen
                @request(delete)

                <input type="text" name="portfolio" value="{{ $portfolio }}">
                <input type="text" name="category" value="{{ $category }}">
                <input type="submit">
            </form>
            @endif
</div>
@endauth



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
        <div class="header-3 t-error pdy-3 content-center">Tato kategorie neobsahuje žádný předmět</div>
    @endif