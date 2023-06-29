<?php if(in_array("admin", ['admin','admin','editor','helper','prod-man','order-man','stat-man','developer','mshop-exp'])) : ?>
    <div class="pd-2 content-right background-dark-3">
        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tento příspěvek?', ()=>{$('#tutorial-delete').submit()})" class="button button-bd-error bd-round-symetric"><i class="fa fa-trash"></i> Smazat</button>
        <button redirect="tutorial/edit/<?php echo $tutorial['url'] ?>" class="button button-warning bd-round-symetric"><i class="fa fa-edit"></i> Upravit</button>
    </div>

    <form hidden id="tutorial-delete" method="post" action="tutorial/delete/<?php echo $tutorial['url'] ?>">
        <input hidden type="text" name="token" value="48299f930253cbcbe2a4704d9a0ca6ddcb27d2148fa680ea3b1892c75a536da4"> <input hidden type="text" name="SID" value="4c0aca071c7408920814eae3a5bae0c8">
        <input hidden type='text' name='method' value='delete'>
        <input type="submit">
    </form>
<?php endif; ?>

<div class="pd-2">
    <div class="header-3 content-center pdy-2">
        <?php echo $tutorial["title"] ?>
    </div>
    <div class="background-dark-2 pd-2 bd-round-3">
        <?php echo $tutorial["_content"] ?>
    </div>
    <hr>
    <div class="subheader-2 pdy-2">
        <div class="row cols-auto">
            <?php foreach($tutorial[":tags"] as $tag) : ?>
                <div class="column-shrink pd-1">
                    <div class="background-bd-warning pdy-1 pdx-2 bd-round-symetric background-warning-hover t-hover-dark-2 cursor-point">
                        #<?php echo $tag ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>