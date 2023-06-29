<div class='pd-2'>
    <button redirect="mshop" class="button-small button-custom-main-2"><i class="fa fa-chevron-left"></i> Zpět</button>
</div>

<div class="row">
    <div class="column-10-xsm column-5"> <!-- Images of product -->
        <div class="content-center background-dark-2 pd-2"><!-- Main image -->
            <img rel="easySlider" id="view_image" class="height-auto height-256p-xsm" style="max-height: 26em;" src="{{$this->modasset("mshop","img/product/".$product["stock_code"]."/main.png")}}">
        </div>
        <div class="row cols-4-xsm cols-8 pd-1 col-space-2">
            @foreach glob("App/Modules/MshopModule/resources/img/product/".$product["stock_code"]."/thumb/*") as $image @
            @php $img = str_replace("App/Modules/MshopModule/resources/img/product/".$product["stock_code"]."/thumb/", "", $image); @
            @php $full_res = str_replace("/thumb", "", $image); @
            @php $img_id = explode(".", $img); @
                    <div onClick="$('#view_image').attr('src', '/{{$full_res}}')" class="column-shrink pd-5 bd-round-3 transparent-hover-75" style="background: url('/{{$image}}'); background-repeat: no-repeat; background-position: left; background-size: 100% 100%;">

                    </div>
                <form id="product_image_delete_{{$img_id[0]}}" class="display-0" method='post' action='/mshop/manager/product-image-delete'>
                    @csrfgen
                    <input type='text' value='{{$image}}' name="image_file">
                    <input type="text" value="{{$product["stock_code"]}}" name="stock_code">
                    <input type="submit">
                </form>
            @endforeach
        </div>
    </div>
    <div class="column-5 column-10-xsm pd-3">
        <div class="header-3 header-5-xsm t-custom-1">
            {{$product["product_name"]}}
        </div>
                @if $product['recommended'] == 1 @
        
        <div class="t-custom-2">
            <i class='fa fa-check-circle'></i> Doporučujeme
        </div>
        @endif
        <div class="mgy-2 background-dark-3 pd-2 bd-round-3">
            <div class='t-custom-2'>Popis</div>
            <div class=" t-italic subheader-3-xsm">{{$product["short_description"]}}</div>
        </div>
        
        <div class="mgy-4 pdx-2">
            @php $rounded = round($product["evaluation"], 0, PHP_ROUND_HALF_DOWN) @
            Hodnocení: 
            @if $rounded >= 5 @
            <i class="fa fa-star t-warning"></i> 
            <i class="fa fa-star t-warning"></i> 
            <i class="fa fa-star t-warning"></i> 
            <i class="fa fa-star t-warning"></i> 
            <i class="fa fa-star t-warning"></i> 
            (5)
            @else

            @php for($i=0; $i<$rounded; $i++) : @
            <i class="fa fa-star"></i> 
            @php endfor @
            ({{$product["evaluation"]}})
            @endif
        </div>
            
        
        
        <div class="background-dark-3 pdy-1 pdx-2 bd-round-3 content-center-xsm">
            <div class="mgy-2 content-center-xsm">
                @if $product["quantity"] > 0 @
                <span class="mark-create"><i class="fa fa-box"></i> Skladem: {{$product["quantity"]}} ks</span>
                @else
                <span class="mark-warning">Není skladem</span>
                @endif

                @if $product["is_action"] == 1 @
                <span class="mg-2 background-custom-2 pd-1 t-bolder t-dark t-button"><s><i class="fa fa-tag"></i></s> Sleva!</span> 
                @endif
            </div>

            @if !empty($product['_sizes']) @
            <div class="mgy-4 content-center-xsm">
                <div class='header-5 pdy-1'>Dostupné velikosti: </div>
                <select id="select-size" class="input-custom-1">
                    @foreach $product['_sizes'] as $size @
                        @if $size['size_count'] > 0 @
                            <option class="header-5" value="{{$size['size_name']}}">Velikost {{$size['size_name']}} - {{$size['size_count']}} ks</option> 
                        @endif
                    @endforeach
                </select>
                <script>
                    $(document).ready(()=>{
                        $("#product-size").val($('#select-size').val());
                    });
                    
                    var select = $('#select-size');
                    
                    select.change(() => {
                       var getValue = select.val();
                       $("#product-size").val(getValue);
                    });
                </script>
            </div>
            @endif
        </div>
        
        
        <div class="pd-4 content-right mgy-2">
            @if $product["is_action"] == 1 @
                <span class="t-bold header-3"><s>{{$number_utils->parseNumber($product["price"])}} Kč</s></span> 
                <span class="mg-2 t-bold t-custom-2 header-1">{{$number_utils->parseNumber($product["action_prize"])}} Kč<br></span>
            @else
                <span class="t-bold t-custom-2 header-1">{{$number_utils->parseNumber($product["price"])}} Kč</span>
            @endif
        </div>
        
        <div class="row">
            @if $product["quantity"] > 0 @ 
                @if !empty($_SESSION[$ip]["PRODUCTS"]) && in_array($product["stock_code"], $_SESSION[$ip]["PRODUCTS"]) @
                    <div class="column content-right">
                        <div class="">
                            <button title="Toto již máte v košíku, kliknutím přejděte k objednávce" onClick="redirect('mshop/shop/basket')" class="button-small button-create">
                                <i class="fa fa-check-circle"></i> V košíku
                            </button>
                        </div>
                    </div>
                @else
                    <div class="column content-right">
                        <div class="element-group element-group-medium">
                            <input id="quat_{{$product["stock_code"]}}" min="1" value="1" max="{{$product["quantity"]}}" type="number" name="quantity" class="width-50px bd-shop t-shop t-bolder pdx-1">
                            <button onClick="$('#form_to_basket_{{$product["stock_code"]}}').submit();" class="button-small button-custom-main-2">
                                <i class="fa fa-shopping-cart"></i> Do košíku
                            </button>
                        </div>
                    </div>
                        
                    <form id="form_to_basket_{{$product["stock_code"]}}" method="post" class="display-0" action="/mshop/shop/add-basket">
                        @csrfgen
                        <input type="text" name="stock_code" value="{{$product["stock_code"]}}">
                        <input type="text" id="product-size" name="size">
                        <input id='quat_form_{{$product["stock_code"]}}' type='number' name='quantity' value="1">
                        <input type="submit">
                    </form>
                    @js
                        $(document).ready(function()
                        {
                            /*  Get value from input id=#quat_{{$product["stock_code"]}}
                            *   and on change put this value to hidden form input id=#quat_form_{{$product["stock_code"]}}
                            */
                            $("#quat_{{$product["stock_code"]}}").change(function()
                            {
                                var quantity = $(this).val();
                                $("#quat_form_{{$product["stock_code"]}}").attr("value", quantity); 
                            });
                        });                        
                    @endjs
                @endif     
            @else
                <div class="col text-right"><button class="button-small button-basic">
                    <i class="fa fa-info-circle"></i> Dostupnost</button>
                </div>
            @endif
        </div>
    </div>
</div>

<hr>

<div class="display-0 display-1-xsm display-1-sm pd-2">
    <button onClick="location.hash = '#anchor-reviews';" class="button-circle height-32p width-32p button-custom-main-1"><i class="fa fa-star"></i></button>
    <button onClick="location.hash = '#anchor-comments';" class="button-circle height-32p width-32p button-custom-main-1"><i class="fa fa-comments"></i></button>
</div>
<div class="row pd-2"> <!-- Description of product and Discussion -->
    <div class="column-6 column-10-xsm column-10-sm">
        <div class="header-3 header-2-md t-custom-2 mgy-2 pd-1 content-center-xsm">
            Informace o produktu:
        </div>
        <div class="pdx-1">
            {{$easy_text->translateText($product["description"], "85%")}}
        </div>
    </div>
    
    <div id="anchor-reviews" class="column-4 column-10-xsm column-10-sm background-dark-3 mgy-4-sm ">
        <div class="header-3 header-2-md t-custom-2 mgy-2 pd-1 content-center">
            <i class="fa fa-star"></i> Recenze:
        </div>
        
        <div class="pd-1">
            <form method="post" action="mshop/shop/review-insert">
                @csrfgen
                <div class="form-line">
                        <div class="form-label"><label for="review-header">Jméno (nepovinné): </label></div>
                        <input id="review-header" validation="maxchars64" name="review-user" class="input-custom-1 width-50 width-100-xsm pd-1" name="review-header">
                        <div valid-for="#review-header" class="pd-1"></div>
                </div>
                
                <input hidden type="text" name="product-code" value="{{$product['stock_code']}}">
                <input type="hidden" name="rating" id="rating" value="0" />
                
                <div id="eval-stars" onMouseOut="resetRating();" class="form-line">
                    <div class="form-label">Hodnocení:</div>
                    <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                        onClick="addRating(this);" id="eval-star" class="fa fa-star cursor-point eval-star header-6"></i>
                    <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                        onClick="addRating(this);" copy-attr="eval-star:class"></i>
                    <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                        onClick="addRating(this);" copy-attr="eval-star:class"></i>
                    <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                        onClick="addRating(this);" copy-attr="eval-star:class"></i>
                    <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                        onClick="addRating(this);" copy-attr="eval-star:class"></i>
                    
                    <span id="rating-eval" class="header-6 mgx-2">0</span>
                </div>
                
                
                <script>
                    
                    function highlightStar(obj) 
                    {
                        removeHighlight();		
                        $('#eval-stars i').each(function(index) {
                                $(this).addClass('t-warning');
                                if(index == $("#eval-stars i").index(obj)) {
                                        return false;	
                                }
                        });
                    }

                    function removeHighlight() {
                            $('#eval-stars i').removeClass('t-warning');
                    }

                    function addRating(obj) {
                            $('#eval-stars i').each(function(index) {
                                    
                                    $(this).addClass('t-warning');
                                    $('#rating').val((index+1));
                                    if(index == $("#eval-stars i").index(obj)) {
                                        $('#rating-eval').text(index+1);
                                            return false;	
                                    }
                            });
                    }

                    function resetRating() {
                            if($("#rating").val()) {
                                    $('#eval-stars i').each(function(index) {
                                            $(this).addClass('t-warning');
                                            if((index+1) == $("#rating").val()) {
                                                    return false;	
                                            }
                                    });
                            }
                    }
                    
                </script>
                
                <div class='row'>
                    <div class="column-5 column-10-xsm">
                        <label for='plus' class='t-custom-1 header-6'><i class='fa fa-check'></i> Klady: </label><br>
                        <textarea required placeholder="Aa..." validation="maxchars512" class="input-custom-1 width-90 width-100-xsm height-128p v-resy" id="review-plus" name="review-plus"></textarea>
                        <div valid-for="#review-plus" class="pd-1"></div>
                    </div>

                    <div class="column-5 column-10-xsm content-right content-left-xsm">
                        <label for='minus' class='t-error header-6'><i class='fa fa-close'></i> Nedostatky: </label><br>
                        <textarea required placeholder="Aa..." validation="maxchars512" class="input-custom-1 width-90 width-100-xsm height-128p v-resy" id="review-minus" name="review-minus"></textarea>
                        <div valid-for="#review-minus" class="pd-1"></div>
                    </div>
                </div>
                
                <div class="form-line">
                    <label for='review-text' class='header-6'><i class='fa fa-pen'></i> Obsah recenze: </label><br>
                    <textarea required placeholder="Aa..." style="min-height: 10em;" validation="required,maxchars2048" class="input-custom-1 width-100" id="review-text" name="review-text"></textarea>
                    <div valid-for="#review-text" class="pd-1"></div>
                </div>
                
                <div class="form-line">
                    <button class='button button-custom-main-1'>Odeslat</button>
                </div>
            </form>
        </div>
        
        <div class="">
            @if empty($product['reviews']) @
                <div class='header-4'>Žádné recenze nejsou k dispozici</div>
            @else
                @foreach $product['reviews'] as $review @
                <div class=' background-dark-2 pd-2 mgy-2'>
                    <div class='content-center-xsm pd-2 header-5'>
                        <div class='row'>
                            <div class='column'>
                                @php $rounded = $review["rank"] @

                                @if $rounded >= 5 @
                                <i class="fa fa-star t-custom-2"></i> 
                                <i class="fa fa-star t-custom-2"></i> 
                                <i class="fa fa-star t-custom-2"></i> 
                                <i class="fa fa-star t-custom-2"></i> 
                                <i class="fa fa-star t-custom-2"></i> 
                                
                                @elseif ($rounded == 0) @
                                    <i class="fa fa-star t-light"></i> (0)
                                @else

                                    @php for($i=0; $i<$rounded; $i++) : @
                                    <i class="fa fa-star t-warning"></i> 
                                    @php endfor; @

                                @endif
                            </div>
                            <div class='column content-right'>
                                <span class="t-custom-1 t-bolder">{{$review["author"]}}</span> {{DATE("d.m.Y H:i:s", $review['updated_at'])}} 
                            </div>
                        </div>
                    </div>
                    <div class='pd-2 mgy-2'>
                        {{$review['content']}}
                    </div>
                    
                    <div class="header-6 t-custom-1 pdx-2 pdy-1">
                        <i class='fa fa-check'></i> 
                        @if empty($review['plus']) @
                         NIC
                        @else
                         {{$review['plus']}}
                        @endif
                    </div>
                    
                    <div class="header-6 t-error pdx-2 pdy-1">
                        <i class='fa fa-close'></i> 
                        @if empty($review['minus']) @
                         NIC
                        @else
                         {{$review['minus']}}
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
            
        </div>
    </div>
    
</div>
<hr>

<div id="anchor-comments" class="row">
    <div class="column-2 column-10-xsm column-10-sm"></div>
    <div class="column-4 column-10-xsm column-10-sm pd-1">
        <div class="header-3 header-2-md t-custom-2 mgy-2 content-center">Diskuze: </div>

        <div class="">
            <div class="">
                <form method="post" action="/mshop/shop/discussion-insert">
                    @csrfgen
                    <input hidden name='product-url' value='{{$product['stock_code']}}'>
                    <div class="form-line">
                        <div class="form-label"><label for="discussion-header">Název diskuze: </label></div>
                        <input id="discussion-header" validation="required,maxchars64" name="discussion-header" class="input-custom-1 width-100 pd-1" name="discussion-header">
                        <div valid-for="#discussion-header" class="pd-1"></div>
                    </div>

                    @ifguest
                    <div class="form-line">
                        <div class="row">
                            <div class="column-4">
                                <div class="form-label"><label for="discussion-author">Jméno: </label></div>
                                <input id="discussion-author" validation="max-chars64" name="discussion-author" class="input-custom-1 width-90 pd-1" name="discussion-author">
                                <div valid-for="#discussion-author" class="pd-1"></div>
                            </div>
                            <div class="column-6">
                                <div class="form-label"><label for="discussion-author">Email: </label></div>
                                <input id="discussion-email" validation="maxchars128,email" name="discussion-email" class="input-custom-1 width-100 pd-1" name="discussion-author">
                                <div valid-for="#discussion-email" class="pd-1"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-line">
                        <div class="form-label"><label for="discussion-text">Obsah: </label></div>
                        <textarea style="min-height: 10em;" validation="required,maxchars2048" class="input-custom-1 width-100" id="discussion-text" name="discussion-text"></textarea>
                        <div valid-for="#discussion-text" class="pd-1"></div>
                    </div>

                    <div class="row form-line cursor-point">
                        <div class='column column-10-xsm content-center-xsm'>
                            <input id="discussion-ask-company" type="checkbox" name="discussion-ask-company">
                            <label for="discussion-ask-company">Dotaz výhradně pro GOTA</label>
                        </div>
                        <div class='column column-10-xsm content-right content-center-xsm'>
                            <button class='button button-custom-main-2'>Odeslat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <p class="mgy-10"></p>
        @if empty($product["disscussion"]) @
            <div class="t-custom-1 header-4 content-center pdy-2">Žádná aktivní diskuze</div>
        @else

            @foreach $product["disscussion"] as $dis @
            
            @if $dis['for_company'] == 0 @
                @php $color = "light" @
            @else
                @php $color = "custom-1" @
            @endif
            <div id="disscussion-{{$dis['id']}}" class='mgy-2 background-dark-2 pd-1 bd-round-2'>
                <div class='pdx-1 pdy-2 t-bolder t-{{$color}}'>
                     @if $dis['for_company'] == 1 @
                    <i class='fa fa-home'></i> 
                    @else
                    <i class='fa fa-comment'></i> 
                    @endif
                    {{$dis['title']}}
                </div> <!-- Title -->
                <div class='pd-1 t-bolder'>
                    <i class="fa fa-user"></i> 

                    {{DATE("d.m.Y H:i:s", $dis["updated_at"])}}
                </div> <!-- Author, date etc -->
                <div class='content-justify pdy-4 pdx-1 pdy-2-xsm t-italic t-{{$color}}'>

                    {{$dis["content"]}}
                </div>

                    <hr>
                    
                    @if $dis['for_company'] == 0 @
                    <div class='mgy-1'>
                        <form method='post' action='/mshop/shop/disscussion-add-comment/{{$dis['id']}}'>
                            @csrfgen
                            <input hidden type="text" name="product_code" value="{{$product["stock_code"]}}">
                            @ifguest
                            <div class="mgy-1">
                                <input id="cmt-name-{{$dis['id']}}" type="text" name="cmt-name" validation="maxchars64" class="input-custom-1 width-100-xsm" placeholder="Jméno (nepovinné)">
                                <div class="pd-1" valid-for="#cmt-name-{{$dis['id']}}"></div>
                            </div>
                            @endif
                            <div>
                                <div>
                                    <textarea id='cmt-content-{{$dis['id']}}' name='cmt-content' validation="required,maxchars1024" class='input-custom-1 width-100 v-resy' placeholder='Odpovědět k: {{$dis['title']}} ...'></textarea>
                                </div>
                            </div>
                            <div class="pdy-1 content-center">
                                <button type="submit" class="button button-custom-main-1"><i class="fa fa-comment"></i> Opovědět</button>
                            </div>
                            <div class="pd-1 pd-2-xsm" valid-for="#cmt-content-{{$dis['id']}}"></div>
                        </form>
                    </div>
                    @endif
                    
                    <hr>
                    <div class="pd-1 header-6">
                        Komentáře: 
                    </div>

                    @if !empty($dis['comments']) @
                    
                        @foreach $dis['comments'] as $comment @
                        <div class='row'>
                            <div class='column-1 column-10-xsm'></div>

                            <!-- COMMENT BLock -->
                            <div class='column-8 column-10-xsm'>
                                <div class='pdx-1 pdy-2 t-bolder t-{{$color}}'>
                                    <div class="background-dark-3 pd-2 bd-round-3">
                                        <div class="pdy-1">
                                            @if $comment['from_company'] == 1 @
                                            <div class="t-custom-1">
                                            <i class='fa fa-home'></i>
                                            @else
                                            <div class="t-light">
                                            <i class='fa fa-comment'></i>
                                            @endif
                                              {{$comment['author']}} | <small>{{DATE('d.m.Y H:i', $comment['updated_at'])}}</small>
                                            </div>
                                        </div>
                                        <div class="pd-1">
                                            {{$comment['content']}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <div class='column-1 column-10-xsm'></div>
                        </div>
                        @endforeach
                    @endif
            </div>
            @endforeach
        @endif
    </div>
            </div>
    <div class="column-2 column-10-xsm column-10-sm"></div>

</div>
