<div class="pd-2">
    <div class="header-5 pdy-2">Nové téma</div>

    <form method="post" action="forum/theme/insert">
        <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
        <input hidden type='text' name='method' value='insert'>
        <div class="form-line">
            <label for="title" class="form-label">Název</label><br>
            <input required validation="required,maxchars256" id="title" type="text" name="title" class="input-dark width-50 width-100-xsm">
            <div valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="icon" class="form-label">Ikona</label><br>
            <input required validation="required,maxchars128" id="icon" type="text" name="icon" class="input-dark width-20 width-50-xsm" value="fa fa-comments">
        </div>

        <div class="form-line">
            <label for="description" class="form-label">Popis</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Přidat</button>
        </div>
    </form>
</div>