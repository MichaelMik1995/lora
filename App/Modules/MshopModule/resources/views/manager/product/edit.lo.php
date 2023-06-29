
<div class="">  
    <div class="row background-dark-2 pd-1 bd-round-3">
        <div class='column-1 column-10-xsm'>
            <button onClick="redirect('mshop/manager/products')" class="button-small button-custom-main-2"><i class="fa fa-chevron-left"></i> Zpět</button>
        </div>
        <div class='column-9 column-xsm content-right pdx-3 pdx-0-xsm content-center-xsm'>
            <span class="header-3">Úprava produktu</span><br>
            <small class="t-custom-1">#{{$product["stock_code"]}}</small>
        </div>
    </div>
    
        <div class="row mgx-1 mgy-md-1 pdy-2">
            <div class="column-4 column-10-xsm col-space-1">
                <div class="content-center">
                <img rel="easySlider" id="view_image" class="mgy-2" style="max-height: 256px;" src="{{$this->modasset("mshop","img/product/".$product["stock_code"]."/main.png")}}">
                </div>
                
                <div class="row cols-4-xsm cols-5 pd-1">
                @foreach glob("App/Modules/MshopModule/resources/img/product/".$product["stock_code"]."/thumb/*") as $image @
                @php $img = str_replace("App/Modules/MshopModule/resources/img/product/".$product["stock_code"]."/thumb/", "", $image); @
                @php $full_res = str_replace("/thumb", "", $image); @
                @php $img_id = explode(".", $img); @
                    @if $img_id[0] != "main" @
                        <div onClick="$('#view_image').attr('src', '/{{$full_res}}')" class="text-left column-shrink mg-2 pdy-4 pdx-1 bd-round-3 mshop-image-gallery" style="background: url('/{{$image}}'); background-repeat: no-repeat; background-position: left;">
                            <button onClick="if(confirm('Opravdu chcete smazat tento obrázek?')){$('#product_image_delete_{{$img_id[0]}}').submit();}" class='mg-auto button-small button-bd-error'><i class='fa fa-window-close'></i></button>
                        </div>
                    <form id="product_image_delete_{{$img_id[0]}}" class="display-0" method='post' action='/mshop/manager/product-image-delete'>
                        @csrfgen
                        <input type='text' value='{{$image}}' name="image_file">
                        <input type="text" value="{{$product["stock_code"]}}" name="stock_code">
                        <input type="submit">
                    </form>
                    @endif
                @endforeach
                </div>
                
                <div class="background-dark-2 mgy-2">
                    <div class="background-create2 t-button t-light">Nahrát obrázky</div>
                    <br>
                    <form method="post" action="/mshop/manager/product-add-images" enctype="multipart/form-data">
                        @csrfgen
                        <input required class="input-custom-1 mgy-2" type="file" name="images[]" id="images" multiple>
                        <button class="button-large button-custom-main-1" type="submit"><i class="fa fa-cloud"></i><span class="display-0-md">Nahrát</span></button>
                        <input hidden type="text" value="{{$product["stock_code"]}}" name="stock_code">
                    </form>
                </div>
            </div>
            
            <div class="column-6 column-xsm">
                <div class="header-3 t-custom-2 pdy-3 pdx-1">{{$product["product_name"]}}</div>
                <div class="pdy-3 pdx-1 header-6">
                    {{$product["short_description"]}}
                </div>
            </div>
        </div>
        <hr>
        <div class="background-dark-2 pd-2 mgy-1 content-center bd-round-3">
            <span class="header-4">Změna údajů</span>
        </div>
        
        <div id="product-header" class="header-5 pd-1 mgy-2 t-bolder">Hlavní:</div>
        
        <form id="product_save" method="post" action="/mshop/manager/product-update" enctype='multipart/form-data'>
        @csrfgen
        <input type="text" hidden name="stock_code" value="{{$product["stock_code"]}}">
        
        <div id="product-block" class="background-dark-3 pd-2 bd-dark bd-round-3">
            <div class="form-line">
                <label for="name">Název produktu: </label><br>
                <input type="text" id="name" validation="required,maxchars128" name="name" placeholder="" value="{{$product["product_name"]}}" class="input-custom-1 t-bolder bd-round-3 width-50 width-100-xsm pd-1">
                <div valid-for="#name"></div>
            </div>

            <div class="form-line">
                <label class="t-custom-2 t-bolder" for="price">Typ produktu: </label><br>
                <select class="input-custom-1 t-bolder bd-round-3" name="type">
                    <option value="0">Jednoduchý hmotný produkt</option>
                    <option value="1">Virtuální produkt (Software, 3D model.. atd)</option>
                    <option value="99">Ostatní (Více v popisu)</option>
                </select>
                </div>

            <div class="form-line">
                <label for="price">Cena: </label><br>
                <div class="element-group element-group-large">
                <input step="0.01" type="number" id="price" name="price" value="{{$product["price"]}}" placeholder="" class="bd-custom-2 bd-solid bd-2 t-bolder bd-round-3 pd-1"> 
                <div class="bd-2 bd-solid bd-custom-2 background-custom-2 t-dark-2 pdx-2">Kč</div>
                </div>
            </div>

            <div class="form-line background-dark-2 pd-1 bd-round-3">

                <span class="background-bd-shop t-custom-2 t-button-large t-bolder">Je produkt zlevěný?</span>
                <select class="background-custom-1 t-bolder bd-round-3 pd-2" name="is_action">
                    @if $product['is_action'] == 1 @
                    <option value="1" selected>Ano (Vybráno)</option>
                    <option value="0">Ne</option>
                    @else
                    <option value="1">Ano</option>
                    <option value="0" selected>Ne (Vybráno)</option>
                    @endif
                </select><br>

                <label for="price_action">Cena po slevě: </label><br>
                <div class="element-group element-group-medium">
                <input step="0.01" type="number" id="price_action" name="action_price" value="{{$product["price"]}}" placeholder="" class="bd-custom-2 bd-2 bd-solid t-custom-2 t-bolder bd-round-3 pd-1"> 
                <div class="bd-2 bd-solid bd-custom-2 background-custom-2 t-dark-2 pdx-2">Kč</div>
                </div>
            </div>

            <div class="form-line">
                <span class="background-bd-shop t-create t-button-large t-bolder header-4">Doporučit produkt?</span>
                <select class="background-custom-1 t-bolder bd-round-3 pd-2" name="recommended">
                    @if $product['recommended'] == 1 @
                    <option value="1" selected>Ano (Vybráno)</option>
                    <option value="0">Ne</option>
                    @else
                    <option value="1">Ano</option>
                    <option value="0" selected>Ne (Vybráno)</option>
                    @endif
                </select>
            </div>

            <div class="form-line">
                <label for="stock">Skladem: </label><br>
                <div class="element-group element-group-medium">
                    <input type="number" id="stock" name="stock" value="{{$product["quantity"]}}" placeholder="" class="bd-shop t-custom-2 t-bolder bd-round-3 bd-2"> 
                    <div class="pdx-2 background-custom-1">
                        <select name="grouping" class="bd-2 background-none bd-none">
                            <option value="0" @if $product['grouping'] == 0 @ selected @endif>Kusů</option>
                            <option value="1" @if $product['grouping'] == 1 @ selected @endif>Párů</option>
                            <option value="2" @if $product['grouping'] == 2 @ selected @endif>Kolekcí</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div copy-attr="product-header:class">Velikosti:</div>
        
        <div copy-attr="product-block:class">
            <div class="pdy-1-xsm">
                <div class="content-right pdy-3-xsm ">
                <input disabled type="text" name="sizes" id="sizes" value="{{$product['sizes']}}" class="input-custom-1" placeholder="Velikosti - náhled">
                <input disabled type="text" id="sizes-count" value="{{$product["quantity"]}}" class="input-custom-1 width-64p">
                <button type="button" onClick="$('#sizes').val(''); $('#sizes-count').val('0'); $('.size-row').remove()" class="button button-custom-main-2">Reset</button>
            </div>
           
            <div class="content-center-xsm">
                <div class="t-bold pdy-1-xsm">Zapsat velikosti:</div>
                <input type="text" id="size-name" class="input-custom-1 width-30-xsm" placeholder="Velikost (XS)" value="XS">
                <input type="number" placeholder="Počet (2)" id="size-count" class="bd-round-3 input-custom-1 width-30-xsm" value="0">
                <button type="button" id="add-size" class="input-custom-2 button-custom-main-1"><i class="fa fa-plus-circle"></i> Přidat</button>
            </div>
            </div>
            
            <div id="size-table" class="mgy-2">
                @if !empty($product['sizes']) @
                    @php $size_row_trim = ltrim($product['sizes'], "&"); $size_row = explode("&", $size_row_trim) @

                    @foreach $size_row as $size_line @
                        @php $id = rand(1111, 9999) @
                        @php $line_explo = explode(":", $size_line) @

                        <div id='row-size-{{$id}}' class='row mgy-2 pd-1 background-dark bd-round-3'>
                            <div class='column-1'>{{$line_explo[0]}}</div>
                            <div class='column'>
                                <input type="number" min="0" id="size-{{$id}}" class="input-custom-2" value="{{$line_explo[1]}}">
                                <button type="button" onClick=updateSizeRow('{{$id}}') class="button-circle width-20p height-2Op button-custom-main-2"><i class="fa fa-pen"></i></button>
                            </div>
                            <div class='column-1'><button type='button' onClick="deleteSizeRow('{{$id}}')" class='button-circle button-error width-32p height-32p'><i class='fa fa-trash'></i></button></div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div copy-attr="product-header:class">Popis:</div>
        
        <div copy-attr="product-block:class">
            <div class="form-line">
                <label for="sh_desc">Krátký popis: </label><br>
                <textarea type="text" id="sh_desc" validation="required,maxchars256" name="sh_desc" placeholder="Krátký text ..." class="input-custom-1 t-bolder bd-round-3  width-75 width-100-xsm pd-1">{{$product["short_description"]}}</textarea>
                <div valid-for="#sh_desc"></div>
            </div>

            <div class="form-line">
                <label for="desc">Podrobnosti: </label><br>
                {{$form}}
            </div>
            <div class="content-center-xsm pd-2">
                <select class="background-custom-1 subheader-3 t-bolder pd-2 bd-round-3" name="visibility">
                    @if $product['visibility'] == 0 @
                        <option value="1">Publikovat</option>
                        <option value="0" selected>Skrýt (Vybráno)</option>
                    @else
                        <option value="1" selected>Publikovat (Vybráno)</option>
                        <option value="0">Skrýt</option>
                    @endif

                </select>
            </div>
        </div>
        <input id="product-save-button" hidden type="submit">
    </form>
    
    <div class="form-line content-right content-center-xsm pdx-2 pdy-4-xsm">
        <button id="save-product" type="button" class="button-circle width-50p height-50p button-create"><i class="fa fa-check"></i></button>
        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tento produkt? \n Tuto akci již nelze vzít zpět!', function(){$('#product_delete').submit();})" type="submit" class="button-circle width-50p height-50p button-error mgx-2"><i class="fa fa-trash"></i></button>
    </div>
        
    <form id="product_delete" class="display-0" method="post" action="/mshop/manager/product-delete">
        @csrfgen
        <input type="text" value="{{$product["stock_code"]}}" name="stock_code">
        <input type="submit">
    </form>
        
</div>

<script>
    
    $(document).on("keydown", "form", function(event) { return event. key != "Enter"; }).ready(() => {
        function readURL(input, image, type="default") 
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+image).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);

                if(type==="multiple")
                {
                    $('#images-count').text(input.files.length);
                }
            }
        }
        $("#image").change(function(){
            readURL(this,"main-image-preview");
        });
        
        $("#images").change(function(){
            readURL(this,"image-previews", "multiple");
        });
        
        
        $('#add-size').click((e) => {
            e.preventDefault();
            
            var size_name = $("#size-name");
            var size_count = $("#size-count");
            
            if(size_name.val() !== "" && size_count.val() !== "")
            {
                var get_actual_input = $('#sizes').val();
                
                if (!(get_actual_input.indexOf("&"+size_name.val()+":") >= 0))
                {
                    var line_id = randomInt(1111,9999);
                    
                    var new_size_line_element = "\
                        <div id='row-size-"+line_id+"' class='size-row row mgy-2 pd-1 background-dark bd-custom-1 bd-solid bd-2 bd-round-3'>\n\
                            <div class='column-1 column-2-xsm header-5'>"+size_name.val()+"</div>\n\
                            <div class='column column-7-xsm'>\n\
                                <input type='number' min='0' id="+line_id+" class='input-custom-2' value="+size_count.val()+">\n\
                                <button type='button' onClick=\"updateSizeRow('"+line_id+"')\" class='button-small button-custom-main-2'><i class='fa fa-pen'></i></button>\n\
                            </div>\n\
                            <div class='column-1 column-1-xsm'><button type='button' onClick=\"deleteSizeRow('"+line_id+"')\" class='button-circle button-error width-32p height-32p'><i class='fa fa-trash'></i></button></div>\n\
                        </div>";


                    var new_input_string = "&"+size_name.val()+":"+size_count.val();

                    $('#sizes').val(get_actual_input+new_input_string);

                    $('#size-table').append(new_size_line_element);
                    
                    //ADD Size
                    var sizes_count = $('#sizes-count').val();
                    var new_count = Number(sizes_count)+Number(size_count.val());
                    $('#sizes-count').val(new_count);
                    $('#stock').val(new_count);
                    
                    size_name.val("");
                    size_count.val("0");
                }
                else
                {
                    GUIDialog.dialogInfo("Tato velikost je již zapsaná! Nelze jí zapsat dvakrát");
                }
            }
            else
            {
                GUIDialog.dialogInfo("Není zapsána velikost nebo její počet!");
            }
        });
        
        
    });
    
    $('#save-product').click(()=>{
        var get_overall_quantity = Number($("#stock").val());
        var sizes_count = Number($("#sizes-count").val());
        
        if(get_overall_quantity === sizes_count)
        {
            $("#sizes").removeAttr("disabled");
            $("#sizes-count").removeAttr("disabled");
            $('#product-save-button').trigger("click");
        }
        else
        {
            GUIDialog.dialogInfo("Počet naskladněných kusů nesouhlasí se součtem velikostí!");
        }
    });
    
    function deleteSizeRow(id)
    {
        var row = $('#row-size-'+id);
        var size_name = $('#row-size-'+id+' div:nth(0)').text();
        var size_count = $('#row-size-'+id+' input').val();
        var construct_line = "&"+size_name+":"+size_count;

        var get_input = $('#sizes').val();

        var new_input = get_input.replace(construct_line, "");
        $("#sizes").val(new_input);
        
        //Subtract count
            var sizes_count = $('#sizes-count').val();
            var new_count = Number(sizes_count)-Number(size_count);
            $('#sizes-count').val(new_count);
            $('#stock').val(new_count);
            
            
            
        row.slideUp(200);
    }
        
    function updateSizeRow(id)
    {
        var row = $('#row-size-'+id);
        var size_name = $('#row-size-'+id+' div:nth(0)').text();
        var size_count = $('#row-size-'+id+' input').val();
        
        var get_input = $('#sizes').val();
        
        console.log("clicked: "+size_name);
        
        //find actual count
        
        var row_split_trim = get_input.slice(1);
        
        var split_size = row_split_trim.split("&");
        
        var old_count = '0';
        
        var_construct = "&"+size_name+":"+size_count;
        
        
        
        split_size.forEach((item) => {
            if(str_contains(size_name, item))
            {
                var splitted = item.split(":");
                old_count = splitted[1]; 
            }      
        });
        
        var new_string = get_input.replace("&"+size_name+":"+old_count, var_construct);
        $("#sizes").val(new_string);
        var overral_sizes = Number($('#sizes-count').val());
        
        var get_null = Number(old_count)-Number(size_count); // 7 --> 9
        var update_stock = 0;
        
        if(get_null => 0)
        {
            update_stock = Number(overral_sizes-(old_count-size_count)); // 7  - (7-3)
        }
        else
        {
            update_stock = Number(overral_sizes+(old_count-size_count)); // 7 + (9-7)
        }
        
        $('#sizes-count').val(update_stock);
        $('#stock').val(update_stock);
        
        //Find 
    }
    
</script>
    