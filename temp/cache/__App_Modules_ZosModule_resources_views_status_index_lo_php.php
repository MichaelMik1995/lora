<div class="header-2 content-center t-zos">
    Statusy
</div>

<div class="pdy-2 content-center">
    <button redirect="zos/app/station-status-create" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Nový status</button>
</div>

<div class="row cols-3 cols-1-xsm cols-2-sm">
    <?php foreach($statuses as $status) : ?>
        <div class="column-shrink pd-2">
            <div class="background-dark-3 bd-top-warning pd-2">
                <div class="content-center t-zos header-5"><?php echo $status["name"] ?></div>
                <div class="mgy-2 content-center">
                    <?php echo $status['_description'] ?>
                </div>
                <hr>
                <div class="content-right pd-2">
                    <button redirect="zos/app/station-status-edit/<?php echo $status['slug'] ?>" class="button-circle width-32p height-32p button-warning "><i class="fa fa-edit"></i></button>
                    <?php if($status["slug"] != "nezarazeno") : ?>
                    <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tento status?', () => { $('#zos-status-delete-<?php echo $status['slug'] ?>').submit() })" class="button-circle width-32p height-32p button-error "><i class="fa fa-trash"></i></button>

                    <form class="display-0" id="zos-status-delete-<?php echo $status['slug'] ?>" method="post" action="/zos/app/station-status-delete">
                        <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
                        <input hidden type='text' name='method' value='delete'>
                        <input type="text" name="slug" value="<?php echo $status['slug'] ?>">
                        <input type="submit">
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>