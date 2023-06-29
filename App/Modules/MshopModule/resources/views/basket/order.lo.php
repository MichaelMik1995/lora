<div class="header-3 t-custom-1 pdx-2">
    Vyplňte fakturační údaje: 
</div>

<div class="row pd-2">
    <div class="column-10-xsm column-6 column-10-sm background-dark-2 pd-1">
        <form id="order_form" method="post" action="/mshop/shop/order-update">
            @csrfgen
            <div class="row mgy-4 mgy-2-md col-space-1">
                <div class="column-10-xsm column">
                    <input hidden type="text" name="order_id" value="{{$order_id}}">
                    <label for="name">Jméno: </label><br>
                    <input required name="given-name" id="name" validation="required,maxchars128" value="{{input("given-name")}}" type="text" class="input-custom-1 width-100">
                    <div class="form-line mgy-2" valid-for="#name"></div>
                </div>

                <div class="column">
                    <label for="surname">Přijmení: </label><br>
                    <input required name="family-name" id="surname" validation="required,maxchars128" value="{{input("family-name")}}" type="text" class="input-custom-1 width-100">
                    <div class="form-line mgy-2" valid-for="#surname"></div>
                </div>  
            </div>

            <div class="mgy-4 mgy-2-md">
                <label for="email">Email: </label><br>
                <input required name="email" value="{{input("email")}}" id="email" validation="required,email" type="email" class="input-custom-1 width-50 width-100-xsm" value="@">
                <div class="form-line mgy-2" valid-for="#email"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="phone">Telefon: </label><br>
                <input required name="tel" value="{{input("tel")}}" id="phone" validation="required,minchars4,maxchars16" type="text" class="input-custom-1 width-25 width-100-xsm" value="+420">
                <div class="form-line mgy-2" valid-for="#phone"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="country">Země: </label><br>
                <select required id="country" validation="required,maxchars128" name="country" class="input-custom-1 width-25 width-50-xsm">
                    @foreach $states as $state @
                        <option value="{{$state["slug"]}}" @if $order["country"] == $state["slug"] @ selected @endif>{{$state["name"]}}</option>
                    @endforeach
                </select>
                <div class="form-line mgy-2" valid-for="#country"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="adress">Ulice a čp.: </label><br>
                <input required name="street-address" value="{{input("street-address")}}" id="adress"validation="required,maxchars128"  type="text" class="input-custom-1 width-50 width-100-xsm">
                <div class="form-line mgy-2" valid-for="#adress"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="city">Město: </label><br>
                <input required name="city" value="{{input("city")}}" id="city" validation="required,maxchars128" type="text" class="input-custom-1 width-50 width-100-xsm">  
                <div class="form-line mgy-2" valid-for="#city"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="postcode">PSČ: </label><br>
                <input required name="postal-code" value="{{input("postal-code")}}" id="postcode" validation="required,int,maxchars8" class="input-custom-1 width-25 width-50-xsm">
                <div class="form-line mgy-2" valid-for="postcode"></div>
            </div>
            
            <div class="mgy-4 mgy-2-md">
                <label for="note">Poznámka k objednávce (max.: 512 znaků): </label><br>
                <textarea onkeyup="charCounter($(this), '#counter_order')" maxlenght="512" name="note" value="{{input("note")}}" id="note" class="v-resy input-custom-1 width-75 width-100-xsm" style='min-height: 4em;'></textarea>
                <div id="counter_order" class="pd-1">0</div>
                <div class="form-line mgy-2" valid-for="#note"></div>
                
            </div>
        
    </div>
    
    <div class="column-10-xsm column-4 column-10-sm bd-dark1-3 pd-2">
        <h3>Způsob dopravy: </h3>
        <div class="">
            @foreach $transports as $transport @
            <div class="mgy-2">
                <div class="header-5">
                    <input name="transport" type="radio" value="{{$transport["slug"]}}" @if ($order["delivery_type"] == $transport["slug"]) || ($order["delivery_type"]=="" && $transport["slug"]=="vyzvednuti-na-pobocce") @ checked @endif>
                    {{$transport["type"]}}
                </div>
                <div class="">
                    {{$transport["description"]}}
                </div>
                <div class="t-shop content-right">
                    Cena: {{$transport["cost"]}} Kč
                </div>
            </div>
            <hr>
            @endforeach
        </div>
        <input hidden type='submit' id='order_click'>
        </form>   
    </div>
</div>

<div class="content-right content-center-xsm pdx-2 pdy-3">
    <span class="header-5">Celková částka za zboží: <p class="display-0 display-1-xsm display-1-sm pd-1"></p><span class="t-custom-2 t-bolder header-6">{{$number_utils->parseNumber($summary)}} Kč</span></span><br>
    (Po dokončení objednávky připočteme dopravu )
</div>

<div class="content-center mgy-2">
    <button onClick="redirect('mshop/shop/basket')" class="button-large button-custom-main-2"><i class="fa fa-chevron-left"></i> Zpět do košíku</button>
    <button onClick="$('#order_click').trigger('click');" class="button-large button-custom-main-2">Zkontrolovat objednávku <i class="fa fa-chevron-right"></i></button>
</div>