<div class="pd-1">
    <form id="add-new-project" method="post" action="portfolio/insert" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="414f6807aacb39a3497b9f206639ddf0711385a9847da78cd443211a07b9ccad"> <input hidden type="text" name="SID" value="8f80b1631f3f1a11aaa5990dd3ef1a8f">
        @method insert @
        <div class="form-line">
            <div class="row">
                <div class="column-5">
                    <label for="name">Název projektu: </label><br>
                    <input id="name" validation="required,maxchars64" name="name" type="text" class="input-basic pd-2 width-100">
                </div>
                <div class="column-5 mg-auto pd-2 header-6" valid-for="#name">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-1">
                    <label for="url">URL: </label><br>
                    <input id="url" validation="minchars2,maxchars64,url" name="url" type="text" class="input-basic pd-2 width-100">
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#url">
                    
                </div>
            </div>
        </div>
      
        
        <div class="form-line">
            <div class="row">
                <div class="column-3">
                    <label for="techs">Použité technologie: </label><br>
                    <input id="techs" validation="maxchars256" name="techs" type="text" class="input-basic pd-2 width-100">
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#techs">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-2">
                    <label for="web-url">Webové URL: </label><br>
                    <input id="web-url" validation="minchars4,maxchars128" name="web-url" type="text" class="input-basic pd-2 width-100" placeholder="https://">
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#web-url">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <label for="web-start">Začátek tvorby -> Konec tvorby: </label><br>
            <input id="web-start" name="web-start" type="date" class="input-basic pd-2 width-15 width-50-xsm width-50-sm">
             -> 
            <input id="web-end" name="web-end" type="date" class="ws-input-text pd-2 width-15 width-50-xsm width-50-sm">
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-5">
                    <label for="short-desc">Krátký popis: </label><br>
                    <textarea char-count="256:counter" id="short-desc" validation="required,maxchars256" name="short-desc" type="text" class="input-basic pd-2 width-100 v-resy" placeholder="Aa ..."></textarea>
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#short-desc">
                    
                </div>
            </div>        
        </div>
        
        <div class="form-line">
            <label for="image">Prezentační obrázek: </label><br>
            <input id="image" name="image" type="file" class="input-basic pd-2 width-15 width-50-xsm width-50-sm">
        </div>
        
        <div class="form-line">
            <label for="content">Úplný popis: </label><br>
            <?php echo $form ?>
        </div>
        
    </form>
    
</div>
