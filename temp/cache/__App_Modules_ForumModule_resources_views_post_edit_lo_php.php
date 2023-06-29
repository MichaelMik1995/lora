<div class="">
    <form method="post" action="/forum/post-update">
        <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
        <input hidden type='text' name='method' value='update'>
        <input hidden type="text" name="post-url" value="<?php echo $post['url'] ?>">
        <input hidden type="text" name="author" value="<?php echo $post['author'] ?>">

        <div class="form-line">
            <label for="name">Název vlákna:</label><br>
            <input tabindex="1" id="name" type="text" name="title" validation="required,maxchars256" class="input-dark pd-2 width-30 width-75-xsm" value="<?php echo $post['title'] ?>">
        </div>

        <div class="mgy-2 form-line">
            <label for="content">Obsah:</label><br>
            <?php echo $form ?>
        </div>

        <div class="form-line">
            <button class="button button-dxgamepro"><i class="fa fa-edit"></i> Upravit</button>
        </div>
    </form>
</div>