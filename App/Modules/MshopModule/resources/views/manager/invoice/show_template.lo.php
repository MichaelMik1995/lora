<div id="invoice" class="row">
    <div class="column-2"></div>
    <div id='printarea' class="column background-light pd-2 bd-round-3">
        <div class="header-5 content-right t-bolder">Faktura - Daňový doklad č. {{$order['id']}}</div>
        <div class="content-right t-italic">Evidenční číslo: <span class='t-bolder'>{{$order['order_id']}}</span></div>
        
        <div class="row mgy-2">
            <div class="column-3">
                <img src="{{$this->asset('img/logo/main_logo.png')}}" class="height-128p">
            </div>
            
            <div class="column-7 content-right">
                <div class="row"><div class="column-7 content-right">Datum vystavení:</div><div class="column">{{DATE("d.m.Y H:i:s", $order['created_at'])}}</div></div>
                <div class="row"><div class="column-7 content-right">Datum plnění: </div><div class="column">{{DATE("d.m.Y H:i:s", $order['created_at'])}}</div></div>
                <div class="row"><div class="column-7 content-right">Datum splatnosti: </div><div class="column">{{DATE("d.m.Y H:i:s", $order['created_at'])}}</div></div>
                <div class="row"><div class="column-7 content-right">Vystavil: </div><div class="column t-bolder">GOTA</div></div>
                <hr class="mgy-1">
                <div class="row"><div class="column-7 content-right">Forma úhrady:</div><div class="column"> {{$order['_delivery_type']}}</div></div>
                <div class="row"><div class="column-7 content-right">Variabilní symbol: </div><div class="column"><span class="t-bolder">{{$order['order_id']}}</span></div></div>
                <div class="row"><div class="column-7 content-right">Číslo bankovního účtu: </div><div class="column"><span class="t-bolder">12-123456789/0100</span></div></div>
            </div>
        </div>
        
        <hr class="mgy-2">
        <div class="row mgy-2">
            <div class="column">
                <div class="header-5 t-bold t-underline">Dodavatel</div>
                <div class="t-bolder">
                    GOTA Custom s.r.o<br>
                    Sokolovská 1578<br>
                    356 05 Sokolov<br>
                    IČO: 12345678<br>
                    DIČ: 23456789
                </div>
            </div>
            
            <div class="column content-right">
                <div class="header-5 t-bold t-underline">Odběratel</div>
                
                <div class="t-bolder">
                    {{$order['name']}} {{$order['surname']}}<br>
                    {{$order["address"]}}<br>
                    {{$order["post_code"]}} {{$order["city"]}}
                </div>
            </div>
        </div>
        
        <div class="mgy-3 row pd-1 pdy-1 background-dark t-bolder subheader-3">
            <div class="column-1">Počet</div>
            <div class="column-2">Popis</div>
            <div class="column-1 content-center">Cena</div>
            <div class="column-1 content-center">Sazba DPH</div>
            <div class="column-2 content-center">Zákl. DPH</div>
            <div class="column-1 content-center">DPH</div>
            <div class="column content-center">Celkem</div>
        </div>
        <hr>
        
        @php $suma = 0; @
        @foreach $products as $product @
            @php $suma = $suma + $product['price']*$product['quantity'] @
            <div class="mgy-2 row pd-1 subheader-3">
                <div class="column-1">{{$product['quantity']}}x</div>
                <div class="column-2">{{$product['product_name']}}</div>
                <div class="column-1 content-center">{{$number_utils->parseNumber($product['price']-($product['price']/100)*$product["tax"])}} Kč</div>
                <div class="column-1 content-center">{{$number_utils->parseNumber($product["tax"])}} %</div>
                <div class="column-2 content-center">{{$number_utils->parseNumber($product['price']-(($product['price']/100)*$product["tax"]))}} Kč</div>
                <div class="column-1 content-center">{{$number_utils->parseNumber(($product['price']/100)*$product["tax"])}} Kč</div>
                <div class="column content-center">{{$number_utils->parseNumber($product['price'])}}  x {{$product['quantity']}} = {{$number_utils->parseNumber($product['price']*$product['quantity'])}} Kč</div>
            </div>
        @endforeach
        <hr>
        <div class="content-right mgy-1">
            Celkem za položky: <span class="t-bold">{{$number_utils->parseNumber($suma)}} Kč</span>
        </div>
        
        <div class="content-right header-5">
            Poštovné: <span class="t-bold">{{$number_utils->parseNumber($order["delivery_price"])}} Kč</span>
        </div>
        
        <div class="content-right header-3 t-bold mgy-2">
            Celkem k úhradě: {{$number_utils->parseNumber($suma+$order["delivery_price"])}} Kč
        </div>
    </div>
    <div class="column-2"></div>
</div>

@php $get_template = file_get_contents("./App/Modules/MshopModule/resources/templates/invoice/invoice.template");
        
        $invoice_name = $order['id']."_".$order['order_id'];
        
        $invoice_path = "./App/Modules/MshopModule/resources/invoices/$invoice_name/";
        
        if(!is_dir($invoice_path))
        {
            mkdir($invoice_path);
        } 
@


{{$invoice_path}}


<script>
$(document).ready(() => {
    var opt = {
        margin:       1,
        filename:     "{{$invoice_path.$invoice_name.'.pdf'}}",
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
      };

    var htmlpdf = new html2pdf();
    console.log(htmlpdf+" HTML");

    var element = $('#invoice').html();
    htmlpdf().set(opt).from(element).save();
                
});
</script>