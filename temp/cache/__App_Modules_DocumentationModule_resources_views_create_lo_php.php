<div class="pd-2">
    <form method="post" action="/documentation/insert">
        <input hidden type="text" name="token" value="7872da6653d23290937b567aabf28a2bf24ca9629039814f64681268d97051e0"> <input hidden type="text" name="SID" value="537a99128fa62e01b0b08148109afa20">
        <input hidden type='text' name='method' value='insert'>
        
        <div class="form-line">
            <label for="title" class="form-label mgx-1"><?php echo lang("blog_title") ?></label><br>
            <input id="title" name="title" type="text" class="input-dark pd-2 width-50 width-100-xsm" validation="required,maxchars128" placeholder="Aa...">
            <div class="pd-1" valid-for="#title"></div>
        </div>
        
        <div class="row cols-auto width-50 width-100-xsm">
            <div class="column form-line">
                <label for="version" class="form-label mgx-1"><?php echo lang("documentation_version") ?></label><br>
                <select name="version" class="input-dark pd-2 width-100">
                    <option value=""></option>
                    <?php foreach($versions as $version) : ?>
                    <option value="<?php echo $version['url'] ?>"><?php echo $version["version"] ?> - <?php echo $version["description"] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="pdy-1 pdx-3">
                    <i class="fa fa-plus-circle mgx-1"></i> <input type="text" name="add-version" class="width-80" placeholder="<?php echo lang("documentation_add_version") ?>">
                </div>
            </div>

            <div class="column form-line">
                <label for="category" class="form-label mgx-1"><?php echo lang("documentation_category") ?></label><br>
                <select name="category" class="input-dark pd-2 width-100">
                    <option value=""></option>
                    <?php foreach($categories as $category) : ?>
                    <option value="<?php echo $category['url'] ?>"><?php echo $category["title"] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="pdy-1 pdx-3">
                    <i class="fa fa-plus-circle mgx-1"></i> <input type="text" name="add-category" class="width-80" placeholder="<?php echo lang("documentation_add_category") ?>">
                </div>
            </div>
        </div>
        
        <div class="form-line">
            <label for="content" class="form-label mgx-1"><?php echo lang("blog_content") ?></label><br>
            <?php echo $form ?>
        </div>
        
        <div class="form-line">
            <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> <?php echo lang("button_add_record") ?></button>
        </div>
    </form>
</div>

