<div class="pd-2">
    <form method="post" action="/documentation/update">
        <input hidden type="text" name="token" value="e9a399505e9d2ea4e1dbe67d1b1b9e3f7ccf621e7cd7e66862803bfcd6384093"> <input hidden type="text" name="SID" value="9e1f33322bc514221e855a207f44a774">
        <input hidden type='text' name='method' value='update'>
        
        <input hidden type='text' name='url' value='<?php echo $documentation['url'] ?>'>
        <div class="form-line">
            <label for="title" class="form-label mgx-1"><?php echo lang("blog_title") ?></label><br>
            <input id="title" name="title" type="text" class="input-dark pd-2 width-50 width-100-xsm" validation="required,maxchars128" placeholder="Aa..." value="<?php echo $documentation["title"] ?>">
            <div class="pd-1" valid-for="#title"></div>
        </div>
        
        <div class="row cols-auto width-50 width-100-xsm">
            <div class="column form-line">
                <label for="version" class="form-label mgx-1"><?php echo lang("documentation_version") ?></label><br>
                <select name="version" class="input-dark pd-2 width-100">
                    <option value=""></option>
                    <?php foreach($versions as $version) : ?>
                    <option value="<?php echo $version['url'] ?>" <?php if($version['url'] == $documentation['version']) : ?> selected <?php endif; ?>>><?php echo $version["version"] ?> - <?php echo $version["description"] ?></option>
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
                    <option value="<?php echo $category['url'] ?>"  <?php if($category['url'] == $documentation['category']) : ?> selected <?php endif; ?>><?php echo $category["title"] ?></option>
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
            <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> <?php echo lang("button_update_record") ?></button>
        </div>
    </form>
</div>


