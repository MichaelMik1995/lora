
<div class="header-3 pdy-2">
    Výsledky vyhledávání pro: {{$search_string}}. Nalezeno: {{count($products)}}
</div>


<div class='row cols-1-xsm cols-2-sm cols-3 cols-4-xlrg'>
    @foreach $products as $product @
    <div class='column-shrink pdx-1 pdy-1 mgy-2-xsm pd-0-xsm bd-round-3'>
        <div class='width-height-100 bd-2 pd-2 bd-solid bd-dark-2 background-dark-3'>
            <!-- Thumbnail image -->
            <div class='content-center'> <!-- Main Image -->
                <img class="mshop-image-gallery mshop-image-thumbnail" onClick="document.location='/mshop/shop/product-show/{{$product["stock_code"]}}'" height="200" src='{{$this->modasset("mshop","img/product/".$product["stock_code"]."/thumb/main.png")}}' loading="lazy" >
            </div>

            <!-- Product name with href -->
            <div class="pd-1 pdy-2 ws-href subheader-2 t-shop content-center t-bolder" onClick="document.location='/mshop/shop/product-show/{{$product["stock_code"]}}'">
                {{$product["product_name"]}}
            </div>

            <!-- IN STOCK & recommended-->
            <div class="px-5 pdy-2">

                @if $product["quantity"] > 0 @
                <span class="mark-create">Skladem {{$product["quantity"]}} ks</span>
                @else
                <span class="mark-warning">Není skladem</span>
                @endif

                @if $product["is_action"] == 1 @
                <span class="mark-shop"><s>Kč</s> Sleva!</span> 
                @endif

                @if $product["recommended"] == 1 @
                <span class="t-create"><i class="fa fa-check-circle"></i> Doporučujeme!</span>
                @endif
            </div>

            <!-- Product description -->
            <div class="pdy-2 content-justify">
                <span class="t-shop t-bolder">Popis:</span><br>
                {{$product["short_description"]}}
            </div>

            <!-- Product evaluation -->
            <div class="pdy-2 content-justify">
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
            <div class="t-bolder t-shop subheader-3 pdx-2">
                <div class="row mgy-2">
                    <div class="column-10-xsm column mg-auto pdy-1">
                        @if $product["is_action"] == 1 @
                        <s>{{$number_utils->parseNumber($product["price"])}} Kč</s> 
                            <span class="header-4 t-bolder t-shop">{{$number_utils->parseNumber($product["action_prize"])}} Kč</span>
                        @else
                            <span class="header-4 t-bolder t-shop">{{$number_utils->parseNumber($product["price"])}} Kč</span>
                        @endif

                    </div>

                    @if $product["quantity"] > 0 @

                        @if !empty($_SESSION[$ip]["PRODUCTS"]) && in_array($product["stock_code"], $_SESSION[$ip]["PRODUCTS"]) @
                            <div class="column content-right">
                                <div class="">
                                    <button title="Toto již máte v košíku, kliknutím přejděte k objednávce" onClick="redirect('mshop/shop/basket')" class="button-small button-create">
                                        <i class="fa fa-check-circle"></i> V košíku
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="column content-right">
                                <div class="element-group element-group-medium">
                                    <input id="quat_{{$product["stock_code"]}}" min="1" value="1" max="{{$product["quantity"]}}" type="number" name="quantity" class="width-50px bd-shop">
                                    <button onClick="$('#form_to_basket_{{$product["stock_code"]}}').submit();" class="button-small button-custom">
                                        <i class="fa fa-shopping-cart"></i> Do košíku
                                    </button>
                                </div>
                            </div>

                            <form id="form_to_basket_{{$product["stock_code"]}}" method="post" class="display-0" action="/mshop/shop/add-basket">
                                @csrfgen
                                <input type="text" name="stock_code" value="{{$product["stock_code"]}}">
                                <input id='quat_form_{{$product["stock_code"]}}' type='number' name='quantity' value="1">
                                <input type="submit">
                            </form>
                            @js
                                $(document).ready(function()
                                {
                                    /*  Get value from input id=#quat_{{$product["stock_code"]}}
                                    *   and on change put this value to hidden form input id=#quat_form_{{$product["stock_code"]}}
                                    */
                                    $("#quat_{{$product["stock_code"]}}").change(function()
                                    {
                                        var quantity = $(this).val();
                                        $("#quat_form_{{$product["stock_code"]}}").attr("value", quantity); 
                                    });
                                });                        
                            @endjs
                        @endif
                    @else
                        <div class="column text-right"><button class="button-small button-basic">
                            <i class="fa fa-info-circle"></i> Dostupnost</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    @endforeach
</div>