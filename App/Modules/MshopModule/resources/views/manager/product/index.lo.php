<button redirect="mshop/manager/product-create" class="button-large button-custom-main-1 mgy-2"><i class="fa fa-plus-circle"></i> Nový produkt</button>
<div class="pd-1 t-bolder">Celkový počet produktů: {{count($products)}}</div>
<div class="py-4">
    <div class="display-0-xsm row mgy-3 background-dark-3 pd-2 t-custom-2 t-bold">
        <div class="column-1">#</div> <!-- Image header -->
        <div class="column-4 column-10-xsm display-0-xsm">Název</div> <!-- Name header -->
        <div class="column-1 column-2-xsm">Skladem</div> <!-- Quantity header -->
        <div class="column-2 column-xsm">Cena</div> <!-- Price header -->
        <div class="column-1 column-xsm">Zvalidováno</div> <!-- Visibility header -->
        <div class="column-1 column-xsm">Upravit</div> <!-- Visibility header -->
    </div>
    @foreach $products as $product @
    <div class="row mgy-3 pd-1">
        
        <!-- Image -->
        <div class="column-1 column-2-xsm">
            <img class="height-64p bd-round-3 bd-2 bd-custom-1 bd-solid cursor-point" src="{{$this->modasset("mshop","img/product/".$product["stock_code"]."/thumb/main.png")}}">
        </div>
        
        <!-- Name -->
        <div class="column-4 column-8-xsm t-hover-warning cursor-point content-right-xsm pdx-3-xsm" redirect="mshop/manager/manager-product-show/{{$product["stock_code"]}}" >
            <small>#{{$product["stock_code"]}}</small><br>
            <span class="t-bolder">{{$product["product_name"]}}</span>
        </div>
        
        <!-- Quantity -->
        <div class="column-1 column-2-xsm content-center-xsm pdy-1">
            @if $product["quantity"] < 10 @
            <span class="t-error t-bolder">{{$product["quantity"]}} x</span>
            @else
            <span class="t-create t-bolder">{{$product["quantity"]}} x</span>
            @endif
        </div>
        
        <!-- Price -->
        <div class="column-2 column-xsm pdy-1 content-right-xsm">
            @if $product["is_action"] == 1 @
                <span class="t-custom-2 pd-1">Akce! </span><span class="t-custom-2 t-bold">{{$product["action_prize"]}} Kč</span> 
            @else
                <span class="t-custom-2 t-bold">{{$product["price"]}} Kč </span>
            @endif
        </div>
        
        <!-- Visibility -->
        <div class="column-1 column-1-xsm content-center-xsm">
            @if $product["visibility"] == 1 @
            <span class="bd-round-6 t-create"> <i class="fa fa-check"></i><span class="display-0-xsm"> Ano</span></span>
            @else
            <span class="bd-round-6 t-error"><i class="fa fa-close"></i><span class="display-0-xsm"> Ne</span></span>
            @endif
        </div>
        
        <div class="column-1 column-1-xsm content-right-xsm">
            <button redirect="mshop/manager/product-edit/{{$product["stock_code"]}}" class="button-circle width-32p height-32p button-warning"><i class="fa fa-edit"></i></button>
        </div>
        
    </div>
    <hr class="display-0 display-1-xsm">
    @endforeach
</div>