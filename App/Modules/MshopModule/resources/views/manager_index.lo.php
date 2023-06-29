<div class='row mgy-2 background-dark-2 bd-round-3 bd-dark-1 pdx-3 pdy-2 pdx-1-xsm'>
    <div redirect="mshop/manager" class='column-10-xsm column-2 content-center-sm header-4 t-bolder t-custom-2 cursor-point pdy-2-xsm'>
        SHOESBY Manager
    </div>  
    
    <div class="column-10-xsm column content-right content-center-sm pdy-2-xsm">
        <div class="">
            @auth prod-man @
            <button onClick="document.location='/mshop/manager'" class="button button-custom-main-1">
                <i class="fa fa-users-cog"></i> 
                <span class="display-0-md">
                    Správa obchodu
                </span>
            </button>
            @endauth
        </div>
    </div>
</div>

<div class="row">
    <div content-height-auto="manager-index-row" class="column-1 background-dark-2 pd-2 pd-1-xsm">
        <div onClick="redirect('mshop/manager/dashboard')" id="manager-index-button" class="content-center-xsm content-center-sm subheader-3 pdy-3 t-bolder width-100 t-custom-1 cursor-point shift-xp-6-hover anim-shift-fast">
            <i class="fa fa-tachometer-alt"></i><span id="manager-index-button-span" class="display-0-xsm display-0-sm"> Přehled</span>
        </div>
           
        @auth prod-man @
        <div onClick="redirect('mshop/manager/orders')" copy-attr="manager-index-button:class">
            <i class="fa fa-cash-register"></i>
            <span copy-attr="manager-index-button-span:class">  Objednávky ({{$count_orders}})</span>
        </div> 
        
        <div onClick="redirect('mshop/manager/category')" copy-attr="manager-index-button:class">
            <i class="fa fa-clipboard-list"></i><span copy-attr="manager-index-button-span:class">  Kategorie</span></div>
            
        <div onClick="redirect('mshop/manager/products')" copy-attr="manager-index-button:class">
            <i class="fa fa-tshirt"></i>
            <span copy-attr="manager-index-button-span:class">  Produkty ({{$count_unpublished_products}})</span>
        </div>
        
        
        <div redirect='mshop/manager/advert' copy-attr="manager-index-button:class">
            <i class="fa fa-star"></i>
            <span copy-attr="manager-index-button-span:class">  Reklama</span>
        </div>
        
            @auth mshop-exp @
            <div onClick="redirect('mshop/manager/product-discussion')" copy-attr="manager-index-button:class">
                <i class="fa fa-comments"></i>
                <span copy-attr="manager-index-button-span:class">  Diskuze ({{$count_dissccussions}})</span>
            </div>
            @endauth
            
        <div redirect='mshop/manager/transport' copy-attr="manager-index-button:class">
            <i class="fa fa-car"></i>
            <span copy-attr="manager-index-button-span:class">  Doprava</span>
        </div>
        
            <!--
                <div copy-attr="manager-index-button:class">
                    <i class="fa fa-users"></i>
                    <span copy-attr="manager-index-button-span:class">  Zákazníci</span>
                </div>
                @endauth
            -->
        
        @auth developer @
        <div onClick="redirect('mshop/manager/statistic')" copy-attr="manager-index-button:class">
            <i class="fa fa-chart-line"></i>
            <span copy-attr="manager-index-button-span:class">  Statistiky</span>
        </div>
        
        <div onClick="redirect('mshop/manager/log')" copy-attr="manager-index-button:class">
            <i class="fa fa-pencil"></i>
            <span copy-attr="manager-index-button-span:class">  Log</span>
        </div>
        @endauth
        
        <div redirect="mshop/manager/help" copy-attr="manager-index-button:class">
            <i class="fa fa-question-circle"></i>
            <span copy-attr="manager-index-button-span:class">  Nápověda</span>
        </div>
    </div>
    
    <div content-height-auto="manager-index-row" class="column-9 pdx-1">
        @php $this->manager_controll->loadView() @
    </div>
</div>
