@if $category_filter @
    @if count($products) > 4 @
    <div class="row background-dark-3 pd-2 col-space-2">
        <div class="column-10 header-5 pd-1 content-center-xsm">Filtr pro kategorii: {{$subcategory_name}}</div>
        <div title="Zobrazit doporučené produkty" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=recommended&category={{$subcategory}}"><i class="fa fa-check-circle"></i> Doporučené</a></div>
        <div title="Seřadit produkty od nejlevnějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=cheapest&category={{$subcategory}}">Nejlevnější</a></div>
        <div title="Seřadit produkty od nejdražšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=expensive&category={{$subcategory}}">Nejdražší</a></div>
        <div title="Seřadit produkty od nejlépe hodnoceného" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=rating&category={{$subcategory}}">Nejlépe hodnocené</a></div>
        <div title="Seřadit produkty od nejnovějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=new&category={{$subcategory}}">Nejnovější</a></div>
        <div title="Seřadit produkty od neprodávanějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=top-seller&category={{$subcategory}}">Nejprodávanější</a></div>
    </div>
    @endif
@else
    @if count($products) > 4 @
    <div class="row background-dark-3 pd-2 col-space-2">
        <div class="column-10 header-5 pd-1 content-center-xsm">Obecný filtr: </div>
        <div title="Zobrazit všechny doporučené produkty" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=recommended"><i class="fa fa-check-circle"></i> Doporučené</a></div>
        <div title="Seřadit všechny produkty od nejlevnějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=cheapest">Nejlevnější</a></div>
        <div title="Seřadit všechny produkty od nejdražšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=expensive">Nejdražší</a></div>
        <div title="Seřadit všechny produkty od nejlépe hodnoceného" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=rating">Nejlépe hodnocené</a></div>
        <div title="Seřadit všechny produkty od nejnovějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=new">Nejnovější</a></div>
        <div title="Seřadit všechny produkty od nejprodávanějšího" class="column bd-bottom-mshop pd-1 content-center-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=top-seller">Nejprodávanější</a></div>
    </div>
    @endif
@endif

@if $header != "" @
<div class="header-3 content-center-xsm pd-2 pdy-3">
    @if count($products) > 0 @
    {{$header}}
    @else
    Je nám líto, ale v této kategorii se prozatím nenachází žádný produkt
    @endif
</div>
@endif


<div class='row cols-2-xsm cols-3-sm cols-4-md cols-5-lrg cols-4-xlrg'>
    @foreach $products as $product @
    <div redirect="mshop/shop/product-show/{{$product["stock_code"]}}" class='shift-yn-15-hover anim-all-fast transparent-hover-50 cursor-point column-shrink column-xsm pdx-1 pdy-1 mgy-1-xsm pd-0-xsm bd-round-3'>
        <div class='height-100 bd-2 pd-2 bd-solid bd-dark-2 background-dark-3'>
            <div content-height-auto="products-index" class="height-auto">
                
                <!-- Thumbnail image -->
                <div class='content-center'> <!-- Main Image -->
                    <img class="height-128p" src='{{$this->modasset("mshop","img/product/".$product["stock_code"]."/thumb/main.png")}}' loading="lazy" >
                </div>

                <!-- Product name with href -->
                <div content-height-auto="products-index-name" class="pd-1 pdy-2 subheader-2 subheader-3-xsm t-shop content-center t-bolder">
                    {{$product["product_name"]}}
                </div>

                <!-- IN STOCK & recommended-->
                <div content-height-auto="products-index-stock" class="pdy-2 pdy-1-xsm content-center">

                    @if $product["recommended"] == 1 @
                    <i onClick="GUIDialog.dialogInfo('Tento produkt doporučujeme!')" title="Doporučujeme!" class="fa fa-check-circle t-custom-2 mgx-1"></i>
                @endif

                @if $product["is_action"] == 1 @
                    <i onClick="GUIDialog.dialogInfo('Produkt je ve slevě!')" title="Produkt je ve slevě!" class="fa fa-tag t-warning"></i>
                @endif
                
                @if $product["quantity"] > 0 @
                <span class="t-create mgx-1"><i onClick="GUIDialog.dialogInfo('Skladem')" title="Skladem:" class="fa fa-box"></i> <sup>{{$product["quantity"]}}</sup></span>
                @else
                    <i onClick="GUIDialog.dialogInfo('Není skladem')" title="Není skladem" class="fa fa-box t-error"></i>
                @endif  
                </div>

                <!-- Product description -->
                <div content-height-auto="main-product-index-desc" class="pdy-1 pdy-0-sm pdy-1-xsm content-justify content-center-xsm content-center-sm subheader-4-xsm subheader-3-sm">
                <div class="t-custom-1 t-bolder">Popis:</div>
                <div class="">{{$product["short_description"]}}</div>
            </div>

                <!-- Product evaluation -->
                <div class="pdy-2 pdy-1-xsm content-center">
                    @php $rounded = round($product["evaluation"], 0, PHP_ROUND_HALF_DOWN) @ 
                    <span title="Uživatelské hodnocení: {{$product['evaluation']}}">
                    @if $rounded >= 5 @
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    @elseif $rounded < 1 @
                    <i class="fa fa-star-half-stroke t-warning"></i> 
                    @else       
                        @php for($i=0; $i<$rounded; $i++) : @
                        <i class="fa fa-star t-warning"></i> 
                    @php endfor @
                    @endif
                    </span>
                </div>
            </div>
            
            <div class="height-auto">

                <!-- Price & buttons (to basket, no stock) -->
                <div class="t-bolder t-custom-2 subheader-3 pdx-2 pdx-0-xsm content-center">
                    <div content-height-auto="products-index-buttons" class=" mgy-2">
                        <div class="content-center pdy-2 pdy-1-xsm">
                            @if !empty($_SESSION[$ip]["PRODUCTS"]) && in_array($product["stock_code"], $_SESSION[$ip]["PRODUCTS"]) @
                                <i class='header-5 fa fa-shopping-cart t-custom-1 mgx-2'></i>
                                @endif
                        
                            @if $product["is_action"] == 1 @
                            <s>{{$number_utils->parseNumber($product["price"])}} Kč</s><br>
                                <span class="header-3 t-bolder t-custom-2">{{$number_utils->parseNumber($product["action_prize"])}} Kč</span>
                            @else
                                <span class="header-3 t-bolder t-custom-2">{{$number_utils->parseNumber($product["price"])}} Kč</span>
                            @endif

                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @endforeach
</div>