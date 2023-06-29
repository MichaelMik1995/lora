<div class="pd-2">
    <form method="post" action="tutorial/update/<?php echo $tutorial['url'] ?>">
        <input hidden type="text" name="token" value="12416b08cf0fb89f08484ce2f1f3aa3b7efbc0dae4410095354054570b44dc42"> <input hidden type="text" name="SID" value="d939a1ad625877117570ab00fd148d4b">
        <input hidden type='text' name='method' value='update'>

        <input hidden name="url" value="<?php echo $tutorial['url'] ?>">
        <div class="form-line">
            <label for="title">Název návodu</label><br>
            <input id="title" type="text" name="title" class="width-30 width-50-xsm" validation="required,maxchars512" value="<?php echo $tutorial['title'] ?>">
            <div valid-for="#title"></div>
        </div>

        

        <div class="form-line">
            <label for="tags">Tagy</label><br>
            <input autocomplete="off" list="tag-list" id="tags" type="text" name="tags" value="<?php echo $tutorial['tags'] ?>" class="width-30 width-50-xsm" validation="maxchars512" placeholder="Vložit/Vytvořit tag">
            <div valid-for="#tags"></div>

            <datalist id="tag-list">
                <?php foreach($tags as $tag) : ?>
                    <option value="<?php echo $tag ?>">
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="form-line">
            <label title="Stručný popis zobrazující se v návodech" for="short-content">Krátký popis</label><br>
            <textarea id="short-content" name="short-content" class="width-50 height-128p v-resy"><?php echo $tutorial['short_content'] ?></textarea>
        </div>

        <div class="form-line">
            <?php echo $form ?>
        </div>
        
    </form>
</div>