<div class="row">
    <div class="column-2 column-10-xsm pd-2">
        @if !empty($categories) @
        <div id="column-header" class="bgr-dark-2 pdy-2 content-center header-5 header-6-xsm">
            <div class="row">
                <div class="column-8 column-8-xsm">
                    @auth admin @
                        <i redirect="documentation/create" class="fa fa-plus-circle t-info-hover cursor-point"></i>
                    @endauth
                    Navigace</div>
                <div class="column-2 display-0 display-1-xsm">
                    <span onClick="$('#documentation-categories').slideToggle(200)" event-toggle-class="click:fa-close:fa-bars:#view-menu" class="header-5"><i id="view-menu" class="fa fa-bars"></i></span>
                </div>
            </div>
        </div>
        
        <div id="documentation-categories" class="mgy-2 display-0-xsm">
            @foreach $categories as $category @
                @if !empty($category['sheets']) @
                <details class="content-center-xsm bgr-dark-2 pd-2 mgy-1 bd-round-3" open>
                    <summary class='t-light-2 header-4 header-5-xsm'>{{ $category['title'] }}</summary>
                    <div>
                        @foreach $category['sheets'] as $sheet @
                        <div id="{{ $sheet['url'] }}" onClick="generateSheet('{{ $sheet['url'] }}')" class='pdx-5 cursor-point t-info-hover sheet-list'><i class="fa fa-file"></i> {{ $sheet['title'] }}</div>
                        @endforeach
                    </div>
                </details>
                @endif
            @endforeach
        </div>
        @else
        <div class="t-warning t-bold content-center">Žádná kategorie</div>
        @endif
    </div>
    
    <div class="column-8 column-10-xsm pd-2">
        <div copy-attr='column-header:class'>
            Zobrazení listu
        </div>
        <div id="document-sheet" >
            <div copy-attr="column-header:class">Dokumentace</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        generateSheet("vitejte-ve-framworku");

    });
    
    function generateSheet(sheet_url)
    {
        var document_sheet = $("#document-sheet");
        
        var sheet_content = $.post('/documentation/show/'+sheet_url, {
            "url": sheet_url,
            "token": localStorage.getItem("TOKEN"),
            "method": "get",
        });
        
        sheet_content.done((data) => {
           
            console.log(data);
            var jsonRegex = /{.*}/;
            var jsonMatch = data.match(jsonRegex);

            if (jsonMatch != null) 
            {
              var jsonString = jsonMatch[0];

              // Převedení JSON řetězce na objekt
              var jsonObject = JSON.parse(jsonString);
              var edit_access = jsonObject.edit_access;
                            
              var admin_panel = "";
              //replace shortcode to value
              if(edit_access === true)
              {
                  admin_panel = "<div class='content-right pd-1'><button onClick=\"document.location='/documentation/edit/"+sheet_url+"'\" class='button button-warning bd-round-3'>Upravit</button> <button class='button button-error bd-round-3' onClick=\"document.location='/documentation/delete/"+sheet_url+"'\">Smazat</button></div>";
              }
              
              var sheet_cnt = "\
                <div class='pd-2 pd-1-xsm'> \
                       "+admin_panel+" \
                    <div class='content-center header-3 t-bolder pdy-3 pdy-1-xsm'>"+jsonObject.title+"</div>\
                    <div id='document-sheet' class=''>"+jsonObject.content+"</div>\
                </div> \
                ";
              
              document_sheet.html(sheet_cnt);
                
            }
        });
        
        
        sheet_content.fail((data) => {
            document_sheet.html("<div class='t-error'>Nenalezen žádný záznam</div>");
        });
        
        $(".sheet-list").removeClass("t-bolder t-info");
        $("#"+sheet_url).addClass("t-bolder t-info");
        
    }
</script>