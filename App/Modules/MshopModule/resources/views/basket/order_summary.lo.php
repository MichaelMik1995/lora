<div class='pd-1 header-3 header-5-sm content-justify t-custom-1'>
    Objednávka č.{{$order["id"]}} je téměř dokončena!
</div>
<div class="pd-1 content-justify t-italic">
    Nyní si prohlédněte detaily objednávky a pokud vše souhlasí, klikněte na <span onClick="$('#write_order').trigger('click')" class='t-custom-2 cursor-point t-hover-cyan'>DOKONČIT OBJEDNÁVKU</span>
</div>

@foreach $products as $product @
    <div class="row mgy-2 bd-dark-1 pd-2">
        <div class="column-10-xsm column-2 mg-auto content-center-xsm">
            <img rel="easySlider" class="bd-round-3 width-100 width-md-50" src="{{ $this->modasset("mshop", "img/product/".$product['product_code']."/thumb/main.png") }}">
        </div>

        <div class="column-10-xsm column-2 pd-3 pd-md-0 content-center-md">
            <span class='background-custom-2 pd-1 t-dark-2 t-bolder'>Počet: {{$product["quantity"]}} x</span>
        </div>

        <div class="column-10-xsm column-1 column-2-sm mg-auto t-bolder t-shop">
            @if $product["quantity"] == 1 @
                <span class="header-5 t-custom-2">{{$number_utils->parseNumber($product["price"])}} Kč </span>
            @else
                <span class="header-5 t-custom-2">
                    {{$number_utils->parseNumber($product["price"]*$product["quantity"])}} Kč<br>
                </span>

                <span class="">
                    {{$product["quantity"]}} x {{$number_utils->parseNumber($product["price"])}} Kč
                </span>
            @endif
        </div>

        <div class="column-10-xsm column-5 column-4-sm content-justify mg-auto display-0-xsm">
            {{$product["description"]}}
        </div>
    </div>
@endforeach
<hr>
    
<div class=''>
    <table class='table-medium width-75 width-100-xsm'>
        <tr>
            <td>Jméno: </td>
            <td id="order-summary-table-data" class='t-custom-1 t-bolder'>{{$order["name"]}} {{$order["surname"]}}</td>
        </tr>
        <tr>
            <td>Email: </td>
            <td copy-attr="order-summary-table-data:class">{{$order["email"]}}</td>
        </tr>
        <tr>
            <td>Adresa: </td>
            <td copy-attr="order-summary-table-data:class">{{$order["address"]}} {{$order["city"]}} {{$order["post_code"]}}</td>
        </tr>
        <tr>
            <td>Země: </td>
            <td copy-attr="order-summary-table-data:class">{{$order["_country"]}}</td>
        </tr>
        <tr>
            <td>Telefon: </td>
            <td copy-attr="order-summary-table-data:class">{{$order["phone"]}}</td>
        </tr>
        <tr>
            <td>Doprava/Způsob vyzvednutí: </td>
            <td copy-attr="order-summary-table-data:class">{{$order["_delivery_type"]}}</td>
        </tr>
    </table>
</div>

<!-- DIVS For delivery types -->
<div class="pdx-1 pdy-2">
    <form method="post" action="/mshop/shop/write-order">
    @csrfgen
    <input type="text" name="order_id" value="{{$order_id}}" hidden>
    @if $order["delivery_type"] == "vyzvednuti-na-pobocce" @
    <select class="input-custom-1 width-50 width-100-xsm pd-1" name="branch">
        @foreach $branches as $branch @
        <option value="{{$branch["slug"]}}">{{$branch["name"]}}-{{$branch["address"]}}</option>
        @endforeach
    </select>
    @endif
    <input type="submit" id="write_order" hidden>
    </form>
</div>
<div class="pdx-1 pdy-1 header-3 header-4-sm">
    @if $order["delivery_type"] == "platba-predem" @
        <span class="t-create">Pro platbu předem Vám s fakturou zašleme email, kde bude vše napsané</span>
    @endif
    
    @if $order["delivery_type"] == "platba-pri-prevzeti" @
        <span class=" t-create">Nyní nemusíte nic platit, zboží Vám přivezeme na Vaší adresu. Částka za službu je: {{$order["delivery_price"]}} Kč</span>
    @endif
</div>

<div class="content-right pd-1 pdx-3 header-4 content-center-xsm content-center-sm">
    Celková částka k zaplacení: <p class="display-0 display-1-xsm display-1-sm"></p><span class="t-custom-2 t-bolder header-3">{{$number_utils->parseNumber($summary+$order["delivery_price"])}} Kč</span>
</div>

<div class="row mgy-4 pdx-3">
        <div class="column column-2-xsm">
            <button onClick="if(confirm('Opravdu chete zrušit celou objednávku? Tuto akci již nelze vrátit zpět!')){redirect('mshop/shop/remove-order/{{$order["order_id"]}}')}" class="button-large button-custom-main-1">
                <i class="fa fa-window-close"></i> 
                <span class="display-0-xsm">Zrušit celou objednávku</span>
            </button>
        </div>
        <div class="column content-right">
            <button onClick="redirect('mshop/shop/order')" class="button-large button-custom-main-2"><i class="fa fa-chevron-left"></i> <span class="display-0-xsm">Zpět do obchodu</span></button>
            <button onClick="$('#write_order').trigger('click')" class="button-large button-custom"><span class="display-0-xsm">Dokončit objednávku</span> <i class="fa fa-check-circle"></i></button>
        </div>
    </div>