<div class="pd-2">
    <form method="post" action="tutorial/insert">
        <input hidden type="text" name="token" value="c81130fc12cdabdb93a297dee66141425f4778d7486fe6eea28742a4c8a408bf"> <input hidden type="text" name="SID" value="1901a79f9701a429918698d9542a63d1">
        <input hidden type='text' name='method' value='insert'>

        <div class="form-line">
            <label for="title">Název návodu</label><br>
            <input id="title" type="text" name="title" class="width-30 width-50-xsm" validation="required,maxchars512">
            <div valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="tags">Tagy</label><br>
            <input autocomplete="off" list="tag-list" id="tags" type="text" name="tags" class="width-30 width-50-xsm" validation="maxchars512" placeholder="Vložit/Vytvořit tag">
            <div valid-for="#tags"></div>

            <datalist id="tag-list">
                <?php foreach($tags as $tag) : ?>
                    <option value="<?php echo $tag ?>">
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="form-line">
            <label title="Stručný popis zobrazující se v návodech" for="short-content">Krátký popis</label><br>
            <textarea id="short-content" name="short-content" class="width-50 height-128p v-resy"></textarea>
        </div>

        <div class="form-line">
            <?php echo $form ?>
        </div>
        
    </form>
</div>