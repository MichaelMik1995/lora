<div class='pd-2'>
    @backbutton button-basic @
    <button onClick="redirect('mshop/manager/product-edit/{{$product["stock_code"]}}')" class="button button-custom-main-2"><i class="fa fa-edit"></i> Upravit</button>
</div>

<div class="row">
    <div class="column-10-xsm column-5"> <!-- Images of product -->
        <div class="content-center background-dark-2 pd-2"><!-- Main image -->
            <img rel="easySlider" id="view_image" class="height-auto" style="max-height: 26em;" src="{{$this->modasset("mshop","img/product/".$product["stock_code"]."/main.png")}}">
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
        <div class="header-3 t-custom-2">
            {{$product["product_name"]}}
        </div>
        <div class="mgy-2">
            {{$product["short_description"]}}
        </div>
        
        <div class="mgy-4 header-5">
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
                    
            @php for($i=0; $i<$rounded-1; $i++) : @
            <i class="fa fa-star t-warning"></i> 
            @php endfor @
            ({{$product["evaluation"]}})
            @endif
        </div>
        <div class="mgy-2">
            @if $product["quantity"] > 0 @
            <span class="mark-create">Skladem: {{$product["quantity"]}} ks</span>
            @else
            <span class="mark-warning">Není skladem</span>
            @endif
            
            @if $product["is_action"] == 1 @
            <span class="mg-2 background-shop pd-1 t-bolder t-black t-button"><s>Kč</s> Sleva!</span> 
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
    </div>
</div>

<hr>

<div class="row pd-2"> <!-- Description of product and Discussion -->
    <div class="column-10-xsm column-6">
        <div class="header-3 header-2-md t-custom-2 mgy-2 pd-2 content-center-xsm">
            Informace o produktu:
        </div>
        <div class="pdx-1">
            {{$easy_text->translateText($product["description"], "85%")}}
        </div>
    </div>
    
    <div class="column-4 column-10-xsm mgy-4-xsm ">
        
        <div class="pd-1">
            <div class="header-3 header-2-md t-custom-2 mgy-2 content-center-xsm">Diskuze: </div>
           
            @if empty($product['disscussion']) @
                <div class="t-custom-2 header-4 content-center pdy-2">Žádná aktivní diskuze</div>
            @else

                @foreach $product['disscussion'] as $dis @
                
                    @if $dis['for_company'] == 0 @
                        @php $color = "light" @
                    @else
                        @php $color = "custom-1" @
                    @endif

                    <div class='mgy-4 background-dark-3 pd-1 bd-round-2 bd-dark'>
                        <div class='pdx-1 pdy-2 t-bolder header-5 t-custom-1'>{{$dis['title']}}</div> <!-- Title -->
                        <div class='pd-1'>
                            <i class="fa fa-user"></i> 

                            {{DATE("d.m.Y H:i:s", $dis["updated_at"])}}
                        </div> <!-- Author, date etc -->
                        <div class='pd-2 header-6'>
                            {{nl2br($dis["content"])}}
                        </div>


                        <div>
                            <form method="post" action="/mshop/manager/disscussion-add-comment/{{$dis['id']}}">
                                @csrfgen
                                <div class="form-label"><label for="discussion-text">Odpovědět: </label></div>
                                <textarea style="min-height: 10em;" validation="required,maxchars2048" class="input-custom-1 width-100" id="discussion-text" name="content"></textarea>
                                <div valid-for="#discussion-text" class="pd-1"></div>
                                <div>
                                    <button type="submit" class="button button-custom-main-1"><i class="fa fa-send"></i></button>
                                </div>
                            </form>
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
    </div>
</div>
