<script type="text/javascript" src="{{$this->modasset('mshop', 'js/functions.js')}}"></script>
<div class="pd-2">
    @if empty($order) || $order["solved"] == 1  @
        <div class="my-2 pdy-2 header-4 content-center-md">
            Váš košík je momentálně prázdný
        </div>
        <div class="content-center-md header-3 pdy-4">
            <button onClick="redirect('mshop')" class="button-large button-custom">Přejít na domovskou stránku</button>
        </div>
    
    @else
    
    <div class="pd-1 header-5">Objednávka č. <span class="t-custom-2">{{$order['id']}}</span> byla vytvořena dne: <span class="t-bold t-custom-2">{{ DATE("d.m.Y H:i:s", $order["created_at"]) }} hodin</span></div> 
    <div class="t-warning pdx-1">Objednávka bude zrušena následující den v: {{ DATE("H:i:s", $order["expirated_at"]) }} hodin</div>   
    @foreach $all as $order @
        <div class="row mgy-2 bd-dark-1 pd-1">
            <div class="column-10-xsm column-2 column-5-sm mg-auto content-center-xsm">
                <img rel="easySlider" class="bd-round-3 width-100 width-100-sm width-50-md" src="{{ $this->modasset("mshop", "img/product/".$order['product_code']."/thumb/main.png") }}">
            </div>
            
            <div class="column-10-xsm column-2 column-2-sm pd-3 pdy-3-sm pd-md-0 content-center-md">
                <form method="post" action="/mshop/shop/recount-basket">
                    @csrfgen
                    <input hidden type="text" name="product_code" value="{{$order['product_code']}}">
                    <input hidden type="text" name="order_id" value="{{$order['order_id']}}">
                    <span>Počet: </span>
                    <div class="element-group element-group-medium">
                        
                        <input min="1" max="{{$order["product_quantity"]}}" id="quanity_{{$order['id']}}" name="product_new_quantity" type="number" class="pd-1 background-light" value="{{$order["quantity"]}}">
                        <button class="button button-custom-main-2">
                            <i class="fa fa-check-circle"></i> 
                        </button>
                    </div>
                    <div class="pdy-1">
                        Vybraná velikost: <span class="t-custom-2">{{$order['size']}}</span>
                    </div>
                </form>
            </div>
            
            <div class="column-10-xsm column-1 column-2-sm t-bolder t-shop content-center-xsm pdy-3-sm">
                @if $order["quantity"] == 1 @
                    <div class="header-5 t-custom-2">{{$number_utils->parseNumber($order["price"])}} Kč </div>
                @else
                    <div class="header-5 t-custom-2">
                        {{$number_utils->parseNumber($order["price"]*$order["quantity"])}} Kč
                    </div>

                    <div class="mgy-1">
                        {{$order["quantity"]}} x {{$number_utils->parseNumber($order["price"])}} Kč
                    </div>
                @endif
            </div>
            
            <div class="column-10-xsm column-10-sm column-3 content-justify t-bolder pdy-2-sm">
                {{$order["description"]}}
            </div>
            
            <div class="column-10-xsm column-10-sm column-2 mg-auto content-right">
                <div class="pd-1">
                    <form method="post" action="/mshop/shop/remove-product-from-basket">
                        @csrfgen
                        <input hidden type="text" name="product_code" value="{{$order['product_code']}}">
                        <input hidden type="text" name="order_id" value="{{$order['order_id']}}">
                        <button class="button button-custom-main-1">
                            <i class="fa fa-trash"></i>
                            <span class="display-0-xsm">Smazat produkt</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <hr>
        @endforeach
    
    
    @if $summary != 0 @
    <div class="content-right content-center-xsm pdx-2 pdy-3">
        <span class="header-5">Celková částka za zboží: <p class="display-0 display-1-xsm display-1-sm"></p><span class="t-custom-2 t-bolder header-5">{{$number_utils->parseNumber($summary)}} Kč</span></span>
    </div>
    @endif
    
    @if !empty($all) @
    <div class="row mgy-4 pdx-3">
        <div class="column column-2-xsm">
            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete zrušit celou objednávku? Tuto akci již nelze vrátit zpět!', function(){redirect('mshop/shop/remove-order/{{$order["order_id"]}}')})" class="button button-custom-main-1">
                <i class="fa fa-window-close"></i> 
                <span class="display-0-xsm">Zrušit celou objednávku</span>
            </button>
        </div>
        <div class="column content-right">
            <button onClick="redirect('mshop')" class="button-large button-custom-main-2"><i class="fa fa-chevron-left"></i> <span class="display-0-xsm display-0-sm">Zpět do obchodu</span></button>
            <button onClick="redirect('mshop/shop/order')" class="button-large button-custom-main-2"><span class="display-0-xsm display-0-sm">Přejít k objednávce</span> <i class="fa fa-chevron-right"></i></button>
        </div>
    </div>
    @endif
    @endif
</div>
