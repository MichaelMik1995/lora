<div class="pd-2">
    <div class="header-5">Celkový přehled</div>
    <!-- Customer column -->
    <div class="row cols-4">
        <div id="customer-main-column" class="display-0">
            <div class="column-shrink pd-1">
                <div class="background-dark-2 bd-round-3 pd-1 content-center">
                    <div redirect="mshop/shop/{redirect}" class="header-5 t-hover-basic cursor-point">{title}</div>
                    <div class="t-bold t-custom-2">{content}</div>
                </div>
            </div>
        </div>
        
        <div copy-element="customer-main-column" data="redirect:customer-orders,title:Počet objednávek <i class='fa fa-arrow-up-right-from-square'></i>,content:1"></div>
        <div copy-element="customer-main-column" data="redirect:customer,title:Celkem zaplaceno,content:1 654 Kč"></div>
    </div>
    
    
</div>
