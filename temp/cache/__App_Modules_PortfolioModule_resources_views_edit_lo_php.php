<div class="pd-1">
    <form id="add-new-project" method="post" action="portfolio/update/<?php echo $project['project_url'] ?>" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="86b183f2fa4464a8ff1fb2aa764ea5549b76657c894caac754d1811849f87fe2"> <input hidden type="text" name="SID" value="21df2fa25187cae5af29f5134da43d5d">
        <input hidden type='text' name='method' value='update'>
        <div class="form-line">
            <div class="row">
                <div class="column-5">
                    <label for="name">Název projektu: </label><br>
                    <input id="name" validation="required,maxchars64" name="name" type="text" class="input-basic pd-2 width-100" value="<?php echo $project["project_name"] ?>">
                </div>
                <div class="column-5 mg-auto pd-2 header-6" valid-for="#name">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-3">
                    <label for="techs">Použité technologie: </label><br>
                    <input id="techs" validation="maxchars256" name="techs" type="text" class="input-basic pd-2 width-100" value="<?php echo $project["technology"] ?>">
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#techs">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-2">
                    <label for="web-url">Webové URL: </label><br>
                    <input id="web-url" validation="minchars4,maxchars128" name="web-url" type="text" class="input-basic pd-2 width-100" placeholder="https://" value="<?php echo $project["web_url"] ?>">
                </div>
                <div class="column mg-auto pd-2 header-6 anim-all" valid-for="#web-url">
                    
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <label for="web-start">Začátek tvorby (<?php echo DATE("d.m.Y H:i", $project["project_start_at"]) ?>) -> Konec tvorby (<?php echo DATE("d.m.Y H:i", $project["project_end_at"]) ?>): </label><br>
            <input id="web-start" name="web-start" type="date" class="input-basic pd-2 width-15 width-50-xsm width-50-sm">
             -> 
            <input id="web-end" name="web-end" type="date" class="ws-input-text pd-2 width-15 width-50-xsm width-50-sm">
        </div>
        
        <div class="form-line">
            <div class="row">
                <div class="column-5">
                    <label for="short-desc">Krátký popis: </label><br>
                    <textarea char-count="256:counter" id="short-desc" validation="required,maxchars256" name="short-desc" type="text" class="input-basic pd-2 width-100 v-resy" placeholder="Aa ...">
                        <?php echo $project["short_text"] ?>
                    </textarea>
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

