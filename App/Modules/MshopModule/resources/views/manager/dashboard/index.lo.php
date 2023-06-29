<div class='pd-2'>
    
    <div class='header-3'>Přehled</div>

    <div class="row cols-4 cols-3-sm cols-1-xsm col-space-1">
        <div id='dashboard-column' class='display-0'>
            <div class="column-shrink content-center background-dark-2 mg-2 pd-2 content-center-sm bd-round-3">
                <div class='header-5 pdy-1'>{title}</div>
                <div class="subheader-1 t-custom-2 t-bold">{content}</div>
                <div class='t-italic pd-1'>{value}</div>
            </div>
            
            
        </div>
        <div copy-element='dashboard-column' data="title:Celkový výdělek,content:{{$earning}} Kč,value:Bez poštovného"></div>
        @if !empty($best_product_eval) @
        <div copy-element='dashboard-column' data="title:Nejlépe hodnocený produkt,content:<a class='t-custom-2 t-hover-basic' href='mshop/manager/manager-product-show/{{$best_product_eval["stock_code"]}}'>{{$best_product_eval["product_name"]}}</a>,value:{{$best_product_eval["evaluation"]}}"></div>
        @endif
        
        @if !empty($best_view) @
        <div copy-element='dashboard-column' data="title:Nejvíce prohlížený produkt,content:<a class='t-custom-2 t-hover-basic' href='mshop/manager/manager-product-show/{{$best_view["stock_code"]}}'>{{$best_view["product_name"]}}</a>,value:{{$best_view["visited"]}}"></div>
        @endif
        
        @if !empty($best_buyed) @
        <div copy-element='dashboard-column' data="title:Nejvíce prodávaný produkt,content:<a class='t-custom-2 t-hover-basic' href='mshop/manager/manager-product-show/{{$best_buyed["stock_code"]}}'>{{$best_buyed["product_name"]}}</a>,value:{{$best_buyed["buyed"]}} x"></div>
        @endif
    </div>
</div>