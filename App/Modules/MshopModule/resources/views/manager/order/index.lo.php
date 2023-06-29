<div class="">
    @if empty($all) @
    <span class="header-4">Prozatím zde není žádná aktivní objednávka</span>
    @else
    <div class="content-center-xsm pdy-3">
        <div class="">Vyhledat objednávku:</div>
        <form method="post" action="mshop/manager/order-find">
            @csrfgen
            <input required type="text" name="searched-order-id" class="input-custom-1" placeholder="Hledaná fráze">
            <button type="submit" class="button-large button-custom-main-2"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <hr>
        <div class="row background-dark-3 bd-1 bd-dark-2 bd-round-4 pd-2 display-0-xsm t-custom-2 t-bolder">
            <div class="column-1">
                Číslo objednávky: 
            </div>
            <div class="column-1">
                Katalogové číslo: 
            </div>
            <div class="column-2">
                Zákazník: 
            </div>
            <div class="column-2">
                Vytvořeno dne:  
            </div>
            <div class="column content-right">
                Status:  
            </div>
            <div class="column-1 content-right">
                Faktura
            </div>
        </div>
        @foreach $all as $row @
        <div class="mgy-2-xsm mgy-1 row background-dark-3 background-dark-2-hover mgy-1-sm bd-dark-2 bd-3 pd-2 t-hover-shop cursor-point" onClick="redirect('mshop/manager/order-show/{{$row["order_id"]}}')">
            <div class="column-1 column-10-xsm t-shop pd-1">
                #{{$row['id']}}
            </div>
            <div class="column-1 column-2-sm column-10-xsm pd-1 t-custom-1">
                {{$row['order_id']}}
            </div>
            <div class="column-2 column-sm column-10-xsm pd-1 t-custom-1">
                {{$row['name']}} {{$row['surname']}}
            </div>
            <div class="column-2 column-sm column-6-xsm pd-1 pdy-2-xsm">
                {{DATE("d.m.Y H:i:s", $row['created_at'])}}
            </div>
            
            <div class="column column-9-sm column-5-xsm content-right">
                @if $row['status'] == 0 @ <!-- Newly created -->
                    <span class="mark-warning">Přijato</span>
                @elseif $row['status'] == 1 @ <!-- Processing ... -->
                    <span class="mark-basic">Zaslány informace</span>
                @elseif $row['status'] == 2 @ <!-- Completed -->
                    <span class="mark-create">Dokončeno</span>            
                @elseif $row['status'] == 3 @ <!-- Canceled -->
                    <span class="mark-error">Zrušeno</span>
                @else
                
                @endif
            </div>
            <div class="column-1 column-1-sm content-right">
                @php $invoice = "./App/Modules/MshopModule/resources/invoices/".$row['id']."_".$row['order_id']."/".$row['id']."_".$row['order_id'] @
                @if file_exists($invoice.".pdf") || file_exists($invoice.".html") @
                    <i class="fa fa-check-circle t-create"></i>
                @else
                    <i class="fa fa-close t-error"></i>
                @endif
            </div>
        </div>
        @endforeach
    @endif
</div>
