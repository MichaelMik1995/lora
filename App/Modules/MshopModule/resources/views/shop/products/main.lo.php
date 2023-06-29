

@if !empty($random_product) @

<!-- RANDOM Product View -->
<div id="random_product" class="background-dark-2 pd-2 pd-1-xsm">
    <div class="">
                        <button title="Skrýt náhodný produkt" onClick="$('#random_product').slideUp(200)" class="button button-custom-main-2 mgx-2"><i class="fa fa-eye-low-vision"></i></button>

    </div>
    <div class="header-5 pdy-1 content-center">
        Prohlídněte si:
        <p class="display-0 display-1-xsm display-1-sm"></p>
        <span class="t-custom-1 t-bold">{{$random_product["product_name"]}}</span>
        <p class="display-0 display-1-xsm display-1-sm"></p>
    </div>
    
    <!-- Random product Row -->
    <div class='row'>
        
        <!-- Random product DESCRIPTION+STARS -->
        <div class="column-2 column-10-xsm column-3-sm column-3-md content-justify pd-2">
            <div class="pdy-2 ">
            @php $rounded = round($random_product["evaluation"], 0, PHP_ROUND_HALF_DOWN) @
                <span title="Uživatelská hodnocení: {{$rounded}}">
                    @if $rounded >= 5 @
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    <i class="fa fa-star t-warning"></i> 
                    @elseif $rounded == 0 @
                    <i class="fa fa-star"></i> 
                    @else

                        @php for($i=0; $i<$rounded-1; $i++) : @
                        <i class="fa fa-star"></i> 
                        @php endfor @
                    @endif
                </span>
            </div>   
            <div class="content-justify">
                {{ $random_product["short_description"] }}
            </div>
        </div>
        
        <!-- Random product IMAGE -->
        <div class="column-6 column-10-xsm column-4-sm column-4-md content-center">
            <img style="max-height: 32em;" src='{{$this->modasset("mshop", "img/product/".$random_product["stock_code"]."/main.png")}}'>
        </div>
        
        <!-- Random product PRICE+BUTTON -->
        <div class="column-2 column-10-xsm column-3-sm column-3-md content-center">
            <div class="pdy-1-xsm header-1 header-4-xsm header-3-sm header-3-md">
                @if $random_product["is_action"] == 1 @
                    <div class="t-bold subheader-3"><s>{{$number_utils->parseNumber($random_product["price"])}} Kč</s></div> 
                    <div class="mg-2 t-bold t-custom-2 subheader-1 subheader-3-sm">{{$number_utils->parseNumber($random_product["action_prize"])}} Kč</div>
                @else
                    <div class="t-bold t-custom-2 subheader-1 subheader-3-sm">{{$number_utils->parseNumber($random_product["price"])}} Kč</div>
                @endif
            </div>
            <div class="mgy-2">
                <button onClick="redirect('mshop/shop/product-show/{{$random_product["stock_code"]}}')" class="button-xlarge button-custom-main-2">Zobrazit produkt <i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</div>
@endif

@if !empty($advert) @
<div class='mgy-2 t-custom-1 content-center pdy-1 background-dark-2 bd-round-3'>
    <div class="subheader-2"><i class="fa fa-star"></i> Víte že: </div>
    <div class="subheader-1"># {{$advert['_content']}}</div>
</div>
<hr>
@endif

@if !empty($newest) @
<div class="header-4 content-center-xsm content-center-sm pdy-2">
    Nejnovější produkty
</div>

<div class="row cols-2-xsm cols-3-sm cols-3-md cols-4-lrg cols-5-xlrg">
    @foreach $newest as $product @
    <div redirect="mshop/shop/product-show/{{$product["stock_code"]}}" class='shift-yn-15-hover anim-all-fast transparent-hover-50 cursor-point column-xsm column-shrink pd-1 mgy-2-xsm pd-0-xsm bd-round-3'>
        <div class='bd-2 pd-2 bd-solid bd-dark-2 background-dark-3'>
            <!-- Thumbnail image -->
            <div content-height-auto="main-image" class='content-center'> <!-- Main Image -->
                <img class="height-128p" src='{{$this->modasset("mshop","img/product/".$product["stock_code"]."/thumb/main.png")}}'>
            </div>

            <!-- Product name with href -->
            <div content-height-auto="main-product-name" class="pd-1 pdy-2 subheader-2 subheader-3-xsm t-shop content-center t-bolder">
                {{$product["product_name"]}}
            </div>

            <!-- IN STOCK & recommended--> 
            <div content-height-auto="main-product-info" class="t-custom-2 pdy-2 header-5 header-6-sm subheader-1-xsm content-center">
                @if $product["recommended"] == 1 @
                    <i onClick="GUIDialog.dialogInfo('Tento produkt doporučujeme!')" title="Doporučujeme!" class="fa fa-check-circle mgx-1"></i>
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
            <div content-height-auto="main-product-desc" class="pdy-1 pdy-0-sm pdy-1-xsm content-justify content-center-xsm content-center-sm">
                <div class="t-custom-1 t-bolder header-5 subheader-3-xsm subheader-3-sm subheader-1-md">Popis:</div>
                <div class="header-6 subheader-2-md subheader-4-xsm subheader-4-sm">{{$product["short_description"]}}</div>
            </div>

            <!-- Product evaluation -->
            <div content-height-auto="main-product-eval" class="pdy-2 pdy-1-xsm content-center">
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

            <!-- Price & buttons (to basket, no stock) -->
            <div content-height-auto="main-product-price" class="t-bolder subheader-3 pdx-2 pdx-0-xsm">
                <div class="row mgy-2 mgy-1-xsm">
                    <div class="column-10-xsm column mg-auto-all pdy-2">
                        @if !empty($_SESSION[$ip]["PRODUCTS"]) && in_array($product["stock_code"], $_SESSION[$ip]["PRODUCTS"]) @
                        <i class='header-5 fa fa-shopping-cart t-custom-1 mgx-2'></i>
                        @endif
                        @if $product["is_action"] == 1 @
                        <div>Sleva: <s class="mgx-1">{{$number_utils->parseNumber($product["price"])}} Kč</s></div>
                        <div class="header-4 header-6-sm t-bolder t-custom-2">{{$number_utils->parseNumber($product["action_prize"])}} Kč</div>
                        @else
                            <span class="header-4 header-6-sm t-bolder t-custom-2">{{$number_utils->parseNumber($product["price"])}} Kč</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="header-1 content-center t-custom-2">Je nám líto, ale prozatím zde není žádný produkt</div>
@endif
