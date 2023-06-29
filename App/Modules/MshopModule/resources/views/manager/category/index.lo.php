<div class="my-2">
    <form method="post" action="/mshop/manager/category-insert">
        @csrfgen
        <div class="content-center pdy-3">
            <input focus class="bd-2 bd-solid bd-round-1 header-6 bd-custom-1 t-custom-1" type="text" name="name" placeholder="Nová kategorie">
            <button class="button-large button-custom-main-1">
                <i class="fa fa-plus-circle"></i>
                <span class="display-0-md">Vytvořit</span>
            </button>
        </div>
    </form>


    <!-- Hide/Show buttons -->
    <div class="pdx-2 content-right">
        <button onClick="$('.subcategory-viewer').slideUp(200)" class="button button-custom-main-2"><i class="fa fa-chevron-up"></i></button>
        <button onClick="$('.subcategory-viewer').slideDown(200)" class="button button-custom-main-2"><i class="fa fa-chevron-down"></i></button>
    </div>
    
    @if !empty($categories) @
    <div class="row cols-1-xsm cols-2-sm cols-3-md cols-4-lrg cols-6-xlrg">
        @foreach $categories as $category @
        <div class="column-shrink pd-2">
            <div class="background-dark-3 pd-1 bd-top-cyan">
                <div>
                    <div class="row pd-1">
                        <div onClick="$('#category_{{$category["category_slug"]}}').slideToggle(200)" class="column-7 content-center header-6 cursor-point">
                            <span class="t-custom-1">{{$category["category_name"]}}</span> ({{$category['subcategories_count']}})
                        </div>
                        <div class="column content-right">
                            <button onClick="GUIDialog.dialogConfirm('Opravdu chete smazat tuto kategorii??\nDoporučujeme smazat pouze v případě, že zde nachází pouze prázdné katerorie', function(){$('#delete_cat_{{$category["category_slug"]}}').submit();})" class="button-circle width-32p height-32p button-custom-main-1"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                
                
                <div id="category_{{$category["category_slug"]}}" class="display-0 subcategory-viewer">
                    <form method="post" action="/mshop/manager/subcategory-insert" class="pdy-1">
                        @csrfgen
                        <input hidden type="text" value="{{$category["category_slug"]}}" name="category">
                        <div class="pd-1 content-center">  
                            <div class="element-group element-group-medium">
                                <input placeholder="Nová podkategorie" type="text" name="name">
                                <button class="button button-custom-main-1"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </form><!-- comment -->
                    <hr>
                    @foreach $category['subcategories'] as $subcategory @
                    <div class="row pd-1">
                        <div class="column-1">
                            <button onClick="GUIDialog.dialogConfirm('Opravdu chete smazat tuto podkategorii??\nDoporučujeme smazat pouze v případě, že se zde nenachází žádný zapsaný produkt.', function(){$('#delete_subcat_{{$subcategory["subcategory_slug"]}}').submit();});" class="button-circle width-32p height-32p button-error"><i class="fa fa-trash"></i></button> 
                        </div>
                        <div class="column column-center pdx-2">
                            {{$subcategory["subcategory_name"]}}
                        </div>
                        <div class="column-2 content-right">
                            ({{ $subcategory['count'] }})
                        </div>
                         
                    </div>
                    
                    <form id="delete_subcat_{{$subcategory["subcategory_slug"]}}" class="display-0" method="post" action="/mshop/manager/subcategory-delete">
                        @csrfgen
                        <input type="text" name="subcategory" value="{{$subcategory["subcategory_slug"]}}">
                    </form>
                    

                    @endforeach
                    
                    
                    
                    <form id="delete_cat_{{$category["category_slug"]}}" class="display-0" method="post" action="/mshop/manager/category-delete">
                        @csrfgen
                        <input type="text" name="category" value="{{$category["category_slug"]}}">
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="header-6 content-center">Není zde žádná kategorie</div>
    @endif
</div>
