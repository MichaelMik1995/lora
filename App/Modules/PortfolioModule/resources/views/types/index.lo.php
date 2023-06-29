<div class="pdy-3 ">
    <div class="element-group element-group-medium">
        <button redirect="portfolio" class="button button-dark"><i class="fa fa-home"></i> Hlavní <i class="fa fa-chevron-right"></i></button>
        <div class="background-dark-2 pdx-2 t-bold">{{ $portfolio_title }}</div>
    </div>    
</div>

    <!-- Admin -->
    @auth admin @
    <div class="content-center pdy-2">
        <button redirect="portfolio/category-create/{{ $portfolio_type }}" class="button button-dark bd-round-symetric">Nová kategorie</button>
        @if $portfolio_type != "all" && $portfolio_type != "nezarazene"  @
        <button redirect="portfolio/type-edit/{{ $portfolio_type }}" class="button button-warning bd-round-symetric">Upravit</button>
        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat toto portfolio?', () => {$('#portfolio-delete').submit()})" class="button button-error bd-round-symetric">Odstranit portfolio</button>

        <form id="portfolio-delete" method="post" action="portfolio/type-delete/{{ $portfolio_type }}" class="display-0">
            @csrfgen
            @request(delete)

            <input type="text" name="type" value="{{ $portfolio_type }}">
            <input type="submit">
        </form>
        @endif
    </div>
    @endauth

    @if file_exists("./App/Modules/PortfolioModule/public/img/type/".$portfolio_type."/image/main.png") @
        @php $main = "./App/Modules/PortfolioModule/public/img/type/".$portfolio_type."/image/main.png" @
    @else
        @php $main = "./public/img/noimagebanner.png" @
    @endif
    <div class="content-center-xsm pdx-3 pdy-4" style="background-color: rgba(0,0,0,0.5); background-image: url('{{ $main }}'); background-size: 100% 100%; background-repeat: no-repeat;">
        
        <div class="">
            <span class="header-1 header-5-xsm pd-1 bd-round-3 t-bold">Portfolio: <span style="color: {{ $color }}">{{ $portfolio_title }}</span></span><br>
            <span class="pdx-5 t-bold">>> {{ $portfolio["description"] }}</span>
        </div>
    </div>

    <!-- Categories CELLS -->
    @if !empty($categories) @
        <div class="row-center cols-5 cols-1-xsm cols-2-sm cols-3-md mgy-5 mgy-2-xsm">
            @foreach $categories as $category @

            @if file_exists("./App/Modules/PortfolioModule/public/img/category/".$category['url']."/image/thumb/main.png") @
                @php $image = "./App/Modules/PortfolioModule/public/img/category/".$category['url']."/image/thumb/main.png" @
            @else
                @php $image = "./public/img/noimage.png" @
            @endif
            <div class="column-shrink pd-2" style="color: {{ $color }}">
                <div redirect="portfolio/category/{{ $category['url'] }}" class="scale-11-hover anim-all-fast bd-round-3" style="background-image: url('{{ $image }}'); background-size: 100%; background-position: center;">
                    <div class="content-center pdy-10 header-3">
                        <span style="background-color: rgba(0,0,0, 0.9)" class="pd-1 bd-round-3">{{ $category["title"] }}</span>
                    </div>
                    <div style="background-color: rgba(0,0,0, 0.9)" class="pd-2 content-center">
                        {{ $category["_description"] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="header-3 t-error pdy-3 content-center">Nebyla nalezena žádná podkategorie</div>
    @endif