<script src="./App/Modules/AdmindevModule/public/js/admindevjs.js"></script>
<div class="row cols-1-xsm">

<div class="column-2"></div>

<div class="column-6">
    <div class="header-4 t-bold pdy-2">
    Vytvoření nového modulu
    </div>

    <div class="">
        <form method="post" action="/admindev/app/module-insert">
            @csrfgen
            @request(insert)

            <div class="background-dark-2 bd-round-4 pd-2">
                <label for="name" class="t-bold">Název modulu:</label><br>
                <input validation="required,minchars2,maxchars64" type="search" id="name" name="name" class="background-dark bd-round-2 bd-none t-light width-100 header-6" placeholder=">> Název modulu...">
                <div valid-for="#name" class="pd-1"></div>
            </div>

            <div class="mgy-2 row cols-2 cols-1-xsm">
                <div class="column pd-1 pdx-0-xsm">
                    <div class="background-dark-2 bd-round-4 pd-2">
                        <label class="t-bold">Modely:</label><br>

                        <div id="models">
                            <!-- Added models -->
                        </div>

                        <div class="content-center pdy-1">
                            <button id="add-new-model" type="button" class="button-circle button-info width-28p height-28p"><i class="fa fa-plus-circle"></i></button>
                        </div>
                    </div>
                </div>

                <div class="column pd-1 pdx-0-xsm">
                    <div class="background-dark-2 bd-round-4 pd-2">
                        <label for="name" class="t-bold">Splittery:</label><br>                            

                        <div id="splitters"></div>

                        <div class="content-center pdy-1">
                            <button id="add-new-splitter" type="button" class="button-circle button-info width-28p height-28p"><i class="fa fa-plus-circle"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="">
                <div class="row cols-2">
                    <div class="column pd-1">
                        
                        <div class="background-dark-2 bd-round-4 pd-2">
                            <div class="header-6 t-bold">Vytvořit migrační tabulku?</div>
                            <div content-height-auto="description-item-column" class="pdy-1 subheader-3 t-italic">
                                    Migrační data tabulky jsou uložená v ./App/Database/Tables/
                            </div>
                            <div class="pdy-1  content-center-xsm">
                                <button type="button" id="check-database-table" class="button-circle width-32p height-32p button-info"><i class="fa fa-close"></i></button>
                                <input hidden id="if-database-table" name="database-tables" type="text" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="column pd-1">
                        
                        <div class="background-dark-2 bd-round-4 pd-2">
                            <div class="header-6 t-bold">Vytvořit testovací data tabulky?</div>
                            <div content-height-auto="description-item-column" class="pdy-1 subheader-3 t-italic">
                                    Testovací data tabulky jsou uložená v .App/Database/Seed/
                            </div>
                            <div class="pdy-1 content-center-xsm">
                                <button id="check-database-data" type="button" id="" class="button-circle width-32p height-32p button-info"><i class="fa fa-close"></i></button>
                                <input hidden id="if-database-data" type="text" name="database-data" value="0">
                            
                            </div>
                        </div>
                    </div>

                    <div class="column pd-1">
                        <div class="background-dark-2 bd-round-4 pd-2">
                            <div class="t-bold">Vytvořit CRUD šablony?</div>
                            <div class="pdy-1 subheader-3 t-italic">
                                    Vytvoří danou složku jako základní a do této vytvoří šablony: index, create, edit, show
                            </div>
                            <input name="template-folder-name" type="text" class="background-dark pd-1 bd-round-2 bd-none t-light width-100 subheader-1" placeholder=">> Název složky">

                            <div class="pdy-1  content-center-xsm">
                                <button type="button" id="check-templates" class="button-circle width-32p height-32p button-info"><i class="fa fa-close"></i></button>
                                <input hidden id="if-check-templates" name="check-templates" type="text" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-line pd-1 background-dark-2 bd-round-4 pd-2 mg-1">
                <div class="header-6 t-bold">
                    Konfigurace modulu
                </div>
                <div class="row cols-3 cols-1-xsm">
                    <div class="column-shrink pd-1 content-center">
                        <div class="background-dark pd-2">
                            <label for="version">Verze:</label><br>
                            <input id="version" type="text" name="version" class="input-dark" value="{{ $WEB_VERSION }}">
                        </div>
                    </div>

                    <div class="column-shrink pd-1 content-center">
                        <div class="background-dark pd-2">
                            <label for="category">Kategorie:</label><br>
                            <input id="category" type="text" name="category" class="input-dark">
                        </div>
                    </div>

                    <div class="column-shrink pd-1 content-center">
                        <div class="background-dark pd-2">
                            <label for="icon">Ikona:</label><br>
                            <input id="icon" type="text" name="icon" class="input-dark" value="fa fa-box">
                        </div>
                    </div>
                </div>

                <div class="mg-1 mgy-4-xsm">
                    <div class="header-6 t-bold">
                        Krátký popis (config.ini)
                    </div>

                    <div>
                        <textarea id="short-text" validation="maxchars128" name="short-description" class="width-50 width-100-xsm v-resy pd-2 t-bold" placeholder="Krátký popis (max. 128 znaků)">Description of module</textarea>
                    </div>

                    <div valid-for="#short-text" class="pd-1"></div>
                </div>
            </div>

            <div class=" pd-1 mgy-2">
                <label for="description" class="t-bold">Popis (Readme.md):</label><br>
                {{ $form }}
            </div>

            <div class="form-line">
                <button class="button-large button-success bd-round-symetric width-100-xsm"><i class="fa fa-plus-circle"></i> Vytvořit modul</button>
            </div>

        </form>
    </div>

</div>
<div class="column-2"></div>

</div>