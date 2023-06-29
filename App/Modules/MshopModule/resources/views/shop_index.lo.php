<div class='pdx-3 pdy-2 pdx-1-xsm'>
    
    <div class=" pdy-2-xsm content-right content-center-xsm content-center-sm">
        <div class="">            
            <button id="shop-buttons-header" redirect="mshop/shop/basket" class="button-large button-custom-main-1 bd-round-3 bd-none t-bolder">
                <i class="fa fa-shopping-cart"></i> 
                <span class="display-0-xsm">
                    Košík
                </span>
                @if $orders != 0 @
                    :{{$orders}}
                @endif               
            </button>
            
            @auth prod-man @
            <button redirect="mshop/manager" copy-attr="shop-buttons-header:class">
                <i class="fa fa-users-cog"></i> 
                <span class="display-0-xsm">
                    Správa obchodu
                </span>
            </button>
            @endauth
        </div>
    </div>
</div>

<div class='row mgy-4'>
    
    <!-- CATEGORIES -->
    <div class="column-10-xsm column-10-sm column-2 background-dark-2">
        <div id="show_category" class="content-right t-shop display-0 display-1-xsm display-1-sm pd-2">
            <button class="button button-custom-main-2 bd-round-3" onClick="$('#category').slideToggle(300); $('#cat-chevron').delay(300).toggleClass('fa-chevron-up fa-chevron-down');"><i id='cat-chevron' class="fa fa-chevron-down"></i> Kategorie</button>
        </div>
        <div id="category" class="display-0-xsm display-0-sm pd-2">
            <div class="header-5 subheader-2-sm header-6-md background-dark-3 pdx-1 pdy-2">
                <div class="row pd-2 mgx-3 mgx-0-md">
                    <div class="column">
                        <span class='t-custom-1 t-hover-light cursor-point'  redirect="mshop/shop/products/sort=recommended">
                            Všechny produkty
                        </span>
                    </div>
                    <div class="column-2 content-center transparent-hover-50 cursor-point" onClick="$('#sort_all').toggle(200); $('#all-sort-chev').toggleClass('fa-chevron-up fa-chevron-down');">
                        <i id='all-sort-chev' class="fa fa-chevron-down"></i> 
                    </div>
                </div>
                <div id="sort_all" class="display-0 pd-2 pd-1-xsm mgx-3 mgx-0-md">
                    <ul class="pd-1">
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=cheapest">Nejlevnější</a></li>
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=expensive">Nejdražší</a></li>
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=rating">Nejlépe hodnocené</a></li>
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=recommended">Doporučené</a></li>
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=new">Nejnovější</a></li>
                        <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=top-seller">Nejprodávánější</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="background-dark-3 ">
            <div class="mgy-2 t-shop t-bolder header-5 subheader-2-sm pdy-2 content-center-sm pdx-2">Kategorie</div>
            @foreach $categories as $category @
            @if $category['subcategories_count'] > 0 @
                <details open class="my-1 pd-2 pd-md-1"> 
                    <summary class="header-5 subheader-1-md subheader-2-sm t-custom-1">{{$category["category_name"]}}</summary>
                    @foreach $category['subcategories'] as $subcategory @
                    
                    @if $subcategory['count']>0 @
                    <div class='background-dark-2 bd-round-3'>  
                        <div class="row pd-2 mgx-3 mgx-1-sm mgx-md-0">
                            <div class="column">
                                <span class='t-light t-hover-shop cursor-point header-6 subheader-3-sm subheader-3-md' onClick="redirect('mshop/shop/products/filter-category={{$subcategory["subcategory_slug"]}}')">
                                    {{$subcategory["subcategory_name"]}} <sub>({{$subcategory['count']}})</sub>
                                </span>
                            </div>
                            <div class="column-2 content-center transparent-hover-50 cursor-point" @if $subcategory['count']>1 @ onClick="$('#sort_{{$subcategory["subcategory_slug"]}}').toggle(200); $('#sub-chev-{{$subcategory["subcategory_slug"]}}').toggleClass('fa-chevron-up fa-chevron-down');" @endif>
                                @if $subcategory['count']>1 @<i id='sub-chev-{{$subcategory["subcategory_slug"]}}' class="fa fa-chevron-down"></i> @endif
                            </div>
                            
                        </div>
                        <div id="sort_{{$subcategory["subcategory_slug"]}}" class="display-0 pd-2 pd-1-xsm mgx-3 mgx-md-0">
                            <ul class="pd-1">
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=cheapest&category={{$subcategory["subcategory_slug"]}}">Nejlevnější</a></li>
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=expensive&category={{$subcategory["subcategory_slug"]}}">Nejdražší</a></li>
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=rating&category={{$subcategory["subcategory_slug"]}}">Nejlépe hodnocené</a></li>
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=recommended&category={{$subcategory["subcategory_slug"]}}">Doporučené</a></li>
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=new&category={{$subcategory["subcategory_slug"]}}">Nejnovější</a></li>
                                <li class="pdy-1-xsm"><a class="a-link t-light t-hover-shop" href="/mshop/shop/products/sort=top-seller&category={{$subcategory["subcategory_slug"]}}">Nejprodávánější</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </details>
            @endif
            @endforeach
            </div>
        </div>
    </div>
    
    <!-- DYNAMIC CONTENT FOR SHOP -->
    <div class="column-8 column-10-xsm column-10-sm pdx-2 pd-0-sm pd-0-xsm">
        @php $this->shop_controll->loadView() @
    </div>
    
</div>

