<div class="">
    <form method="post" action="/zos/app/news-update/<?php echo $new['url'] ?>" enctype="multipart/form-data">
        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="5a4287e15dfb281ce73a8cbf9e85d3a4">
        <input hidden type='text' name='method' value='update'>

        <div class="form-line">
            <label for="title">Název příspěvku</label><br>
            <input id="title" required validation="required,maxchars128" type="text" name="title" value="<?php echo $new['title'] ?>" class="input-dark pd-1 pdy-2 width-50 width-100-xsm pd-2-xsm">
            <div class="pd-1" valid-for="#title"></div>
        </div>

        <div class="form-line">
            <label for="content">Obsah</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line content-center-xsm">
            <div class="mgy-1">
                <label for="image">Vybrat obrázek:</label><br>
                    <?php if(file_exists("./App/Modules/ZosModule/public/img/news/".$new['url']."/thumb/main.png")) : ?>
                        <img rel="easySlider" src="<?php echo modasset('img/news/'.$new['url'].'/thumb/main.png') ?>" class="height-100 height-128p-xsm">
                    <?php else : ?>

                    <?php endif; ?>
            </div>
                    <input type="file" name="image" class="input-dark">
        </div>

        <div class="form-line">
            <button class="button button-info bd-round-symetric width-100-xsm pd-2-xsm header-6-xsm"><i class="fa fa-save"></i> Uložit</button>
        </div>
    </form>
</div>