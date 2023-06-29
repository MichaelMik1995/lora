<div class="">
    @if !empty($categories) @
    <form id="product_create_form" method="post" action="/mshop/manager/product-insert" enctype='multipart/form-data'>
        @csrfgen
        <div id="product-header" class="header-5 pd-1 mgy-2 t-bolder">Hlavní:</div>
        
        <div id="product-block" class="background-dark-3 pd-2 bd-dark bd-round-3">
            <div class="mgy-1 mgy-3-xsm form-line">
                <label for="name">Název produktu: </label><br>
                <input required type="text" id="name" validation="required,maxchars128" name="name" placeholder="Aa..." class="bd-2 bd-solid bd-custom-1 background-light t-dark-2 t-bolder bd-round-3 width-50 width-100-xsm pd-2">
                <div valid-for="#name"></div>
            </div>

            <div class="mgy-1 mgy-3-xsm form-line width-10 width-25-xsm">
                <label for="price">Cena: </label><br>
                <div class="element-group element-group-medium">
                <input step="0.01" type="number" id="price" name="price" min="1" max="99999" value="1" placeholder="" class="bd-2 bd-solid bd-custom-2 background-light t-dark-2  t-bolder bd-round-3 width-100"> 
                <span class="button-small background-custom-2 bd-2 bd-custom-2 t-dark-2">Kč</span>
                </div>
            </div>

            <div class="mgy-1 mgy-3-xsm form-line width-10 width-25-xsm">
                <label for="stock">Skladem: </label><br>
                <div class="element-group element-group-medium">
                <input required type="number" id="stock" name="stock" min="0" max="9999" value="0" placeholder="" class="bd-2 bd-solid bd-custom-2 background-light t-dark-2  t-bolder bd-round-3 width-100"> 
                <span class="button-small background-custom-2 bd-2 bd-custom-2 t-dark-2">Ks</span>
                </div>
            </div>

            <div class="form-line">
                <label for="category">Kategorie: </label><br>

                <select name="category" class="bd-2 bd-solid bd-custom-2 background-light subheader-2 t-bolder bd-round-3 width-30 width-100-xsm pd-1">
                    @foreach $categories as $category @
                    <optgroup class="t-custom-2" label="{{$category["category_name"]}}">
                        @php $get_all = $database->select("mshop-subcategory" , "category_id=?", [$category["category_slug"]]) @
                        @foreach $get_all as $subcategory @
                        <option class="t-dark-2" value="{{$category["category_slug"]}}/{{$subcategory["subcategory_slug"]}}">{{$subcategory["subcategory_name"]}}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div copy-attr="product-header:class">Velikosti:</div>
        
        <div copy-attr="product-block:class">
            <div class="content-right pdy-3-xsm ">
                <input disabled type="text" name="sizes" id="sizes" class="input-custom-1" placeholder="Velikosti - náhled">
                <input disabled type="text" id="sizes-count" value="" class="input-custom-1 width-64p">
                <button type="button" onClick="$('#sizes').val(''); $('#sizes-count').val('0'); $('.size-row').slideUp(200)" class="button button-custom-main-2">Reset</button>
            </div>
           
            <div class="content-center-xsm">
                <div class="t-bold pdy-1-xsm">Zapsat velikosti:</div>
                <input type="text" id="size-name" class="input-custom-1 width-30-xsm" placeholder="Velikost (XS)" value="XS">
                <input type="number" placeholder="Počet (2)" id="size-count" class="bd-round-3 input-custom-1 width-30-xsm" value="0">
                <button type="button" id="add-size" class="input-custom-2 button-custom-main-1"><i class="fa fa-plus-circle"></i> Přidat</button>
            </div>
            
            <div id="size-table" class="mgy-2">
                
            </div>
            
            
        </div>

        <div copy-attr="product-header:class">Obrázky:</div>
        
        <div copy-attr="product-block:class">
            <div class="row mgy-1 mgy-3-xsm form-line">
                <div class="column column-10-xsm content-center"> <!-- Main image -->
                    <div class="pdy-1 header-6">Hlavní obrázek:</div>

                    <div class="background-dark-2">
                        <div class="pdy-2">
                            <img id="main-image-preview" onClick="$('#image').trigger('click')" src="{{$this->asset('img/icon/image.png')}}" class="height-256p">
                        </div>
                    </div>
                    <input hidden type="file" name="main_image" id="image">

                    <br>
                    <img src="" class="cursor-point">
                </div>

                <div class="column content-center"> <!-- Images (max_8) -->
                    <div class="pdy-1 header-6">Prezenční obrázky (<span id="images-count">0</span>):</div>

                    <div class="background-dark-2">
                        <div class="pdy-2">
                            <img id="image-previews" onClick="$('#images').trigger('click')" src="{{$this->asset('img/icon/image.png')}}" class="height-256p">
                        </div>
                    </div>
                    <input hidden type="file" max="8" name="images[]" id="images" multiple>

                </div>
            </div>
        </div>
        
        
        <div copy-attr="product-header:class">Popis:</div>
        
        <div copy-attr="product-block:class">
            <div class="mgy-1 mgy-3-xsm form-line">
                <label for="sh_desc">Krátký popis (MAX. 256 znaků): </label><br>
                <textarea required type="text" validation="required,maxchars256" id="sh_desc" name="sh_desc" placeholder="Krátký text ..." class="bd-2 bd-solid bd-custom-1 background-light t-dark  t-bolder bd-round-3 width-50 width-100-xsm pd-1"> </textarea>
                <div valid-for="#sh_desc"></div>
            </div>


            <div class="mgy-1 mgy-3-xsm form-line">
                <label for="desc">Popis: </label><br>
                {{$form}}
            </div>
        </div>

        <div class="mgy-1 mgy-3-xsm form-line pd-2">
            <button id="create-product" type="button" class="button-large button-custom-main-1">Uložit produkt</button>
            <input id="button-create" hidden type="submit">
        </div>
    </form>
    @else
    <div class="pdy-9 content-center header-5">NELZE VYTVOŘIT PRODUKT! <br>Nejprve vytvořte kategorii a alespoň jednu podkategorii!</div>
    @endif
</div>

<script>
    $(document).ready(() => {
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
                        <div id='row-size-"+line_id+"' class='size-row row mgy-2 pd-1 background-dark bd-round-3'>\n\
                            <div class='column-1'>"+size_name.val()+"</div>\n\
                            <div class='column'>"+size_count.val()+"</div>\n\
                            <div class='column-1'><button type='button' onClick=\"deleteSizeRow('"+line_id+"')\" class='button-circle button-error width-32p height-32p'><i class='fa fa-trash'></i></button></div>\n\
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
    
    $('#create-product').click(()=>{
        var get_overall_quantity = Number($("#stock").val());
        var sizes_count = Number($("#sizes-count").val());
        
        if(get_overall_quantity === sizes_count)
        {
            $("#sizes").removeAttr("disabled");
            $("#sizes-count").removeAttr("disabled");
            $("#button-create").trigger("click");
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
            var size_count = $('#row-size-'+id+' div:nth(1)').text();
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
    
</script>