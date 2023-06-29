<div class='pd-1'>
    <button onClick="redirect('mshop/manager/orders')" class="button-small button-custom"><i class="fa fa-chevron-left"></i> Zpět</button>
</div>

<div class="pd-1 header-4 content-center">
    @if $order['status'] == 0 @ <!-- Newly created -->
        <span class="mark-warning">Přijato</span>
    @elseif $order['status'] == 1 @ <!-- Processing ... -->
        <span class="mark-basic">Zaslány informace</span>
    @elseif $order['status'] == 2 @ <!-- Completed -->
        <span class="mark-create">Dokončeno</span>            
    @elseif $order['status'] == 3 @ <!-- Canceled -->
        <span class="mark-error">Zrušeno</span>
    @else

    @endif
</div>

<div class="t-bolder header-5 content-center-xsm pd-1">Objednávka č.: <span class="t-custom-1">{{$order["id"]}}</span> </div>

<div class="">
@foreach $products as $product @
    <div class="row mgy-2 bd-dark-1 pd-1">
        <div class="column-10-xsm column-1 mg-auto content-center">
            <img redirect="mshop/manager/manager-product-show/{{$product['product_code']}}" class="scale-12-hover anim-scale-normal bd-round-3 width-100" src="{{ $this->modasset("mshop", "img/product/".$product['product_code']."/thumb/main.png") }}">
            <br>
            <div class="pdy-1">{{$product['product_code']}}</div>
        </div>

        <div class="column-10-xsm column-2 mg-auto pd-3 pd-md-0 content-center-md">
            <div class='header-5'>@if $order['issued'] ==1 @ Vydáno: @else Blokováno: @endif
                <span class="t-custom-2 t-bold">{{$product["quantity"]}}x </span> 
                <br> 
                Velikost: <span class="t-custom-2">{{$product['size']}}</span>
                  
            </div>
        </div>

        <div class="column-10-xsm column-1 pd-3 t-bolder t-custom-2 content-center-md">
            @if $product["quantity"] == 1 @
                <span class="header-5">{{$number_utils->parseNumber($product["price"])}} Kč </span>
            @else
                <span class="header-5">
                    {{$number_utils->parseNumber($product["price"]*$product["quantity"])}} Kč<br>
                </span>

                <span class="">
                    {{$product["quantity"]}} x {{$number_utils->parseNumber($product["price"])}} Kč
                </span>
            @endif
        </div>

        <div class="column-10-xsm column-6 content-justify pd-3 display-0-xsm">
            <span class="">{{$product["description"]}}</span>
        </div>
        
    </div>
@endforeach

<div class=''>
    <table class='table-medium width-75 width-100-xsm'>
        <tr>
            <td>Jméno: </td>
            <td class='t-custom-1'>{{$order["name"]}} {{$order["surname"]}}</td>
        </tr>
        <tr>
            <td>Email: </td>
            <td class='t-custom-1'>{{$order["email"]}}</td>
        </tr>
        <tr>
            <td>Adresa: </td>
            <td class='t-custom-1'>{{$order["address"]}} {{$order["city"]}} {{$order["post_code"]}}</td>
        </tr>
        <tr>
            <td>Země: </td>
            <td class='t-custom-1'>{{$order["_country"]}}</td>
        </tr>
        <tr>
            <td>Telefon: </td>
            <td class='t-custom-1'>{{$order["phone"]}}</td>
        </tr>
        <tr>
            <td>Doprava/Způsob vyzvednutí: </td>
            <td class='t-custom-1'>{{$order["_delivery_type"]}}</td>
        </tr>
        <tr>
            <td>Poznámka: </td>
            <td class='t-custom-2'>{{$order["note"]}}</td>
        </tr>
    </table>
</div>

<script>
    $("#select_menu").selectmenu().addClass( "background-shop" );;
</script>

<div class="content-right content-center-sm pd-1 pdx-3 header-4">
    Celková částka k zaplacení: <p class="display-0 display-1-xsm"></p><span class="t-custom-2 header-3 t-bolder">{{$number_utils->parseNumber($summary+$order["delivery_price"])}} Kč</span>
</div>

<div class='pdy-2'>
    @if $order['issued'] == 1 || ($order["status"] == 2 || $order["status"] == 3) @
    <span title=".. Odečteno" class='t-custom-2'>Zboží vydáno ze skladu</span>
    @else
    <button redirect="mshop/manager/order-issue-products/{{$order['order_id']}}" class="button button-custom-main-1 bd-round-symetric"><i class="fa fa-box"></i> Vydat ze skladu</button>
    @endif
</div>

<div class="pdy-2">
    <button class="button button-custom-main-2 mgy-2-xsm " redirect="mshop/manager/invoice-show/{{$order['order_id']}}"><i class="fa fa-eye"></i> Zobrazit fakturu online</button>
    
    @php $invoice = "./App/Modules/MshopModule/resources/invoices/".$order['id']."_".$order['order_id']."/".$order['id']."_".$order['order_id'] @
     
    @if file_exists($invoice.".pdf") @
        <button class="button button-custom-main-1"  onClick="window.open('./App/Modules/MshopModule/resources/invoices/{{$order['id']}}_{{$order['order_id']}}/{{$order['id']}}_{{$order['order_id']}}.pdf')" class=""><i class="fa fa-file-pdf"></i> Zobrazit PDF fakturu</button>
    @elseif file_exists($invoice.".html") @
        <button class="button button-custom-main-1"  onClick="window.open('./App/Modules/MshopModule/resources/invoices/{{$order['id']}}_{{$order['order_id']}}/{{$order['id']}}_{{$order['order_id']}}.html')" class=""><i class="fa fa-file"></i> Tisknout HTML fakturu</button>
    @else
        <button class="button button-custom-main-1" redirect="mshop/manager/invoice-save/{{$order['order_id']}}">Tisknout HTML fakturu</button>
    @endif
        
</div>

@if $order["status"] != 2 && $order["status"] != 3 @
<div class="pd-1 bd-top-create pdy-3 mgy-3">
    <label for="select_menu" class="header-5">Změnit status: </label>
    
    <form method="post" action="/mshop/manager/order-change-status/{{$order['order_id']}}">
        @csrfgen
        <input hidden name="order_id" value="{{$order["order_id"]}}">
        <input hidden name="total_price" value="{{$summary+$order["delivery_price"]}}">
        <input hidden name="email_to" value="{{$order["email"]}}">
            <select id="select_menu" class="input-custom-1 pd-1" name="order_status">
                <option value="1" @if $order["status"] == 1 @ selected @endif>1: Zaslány informace</option>
                <option value="2" @if $order["status"] == 2 @ selected @endif>2: Dokončeno</option>
                <option value="3" @if $order["status"] == 3 @ selected @endif>3: Zrušeno</option>
            </select>
        <button class="button-circle width-50p height-50p background-custom-1 bd-none background-warning-hover"><i class="fa fa-check-circle"></i></button>
    </form>
</div>
@endif

</div>
