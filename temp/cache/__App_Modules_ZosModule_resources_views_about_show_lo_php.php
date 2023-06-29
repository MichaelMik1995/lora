<div class="pdy-1">
</div>


<div class="row pd-2 background-dark-2 bd-round-symetric">
    <div class="column-2">
        <button redirect="zos/app/about" class="button-small button-zos bd-round-symetric"><i class="fa fa-chevron-left"></i><span class="display-0-xsm"> Všechny stránky</span></button>
    </div>
    <div class="column-8 content-right">
        <?php if(in_array("admin", [''])) : ?>
        <button redirect="zos/app/about-edit/<?php echo $page['url'] ?>" class="button button-bd-info bd-round-symetric"><i class="fa fa-edit"></i> Upravit</button>
            <?php if($page['url'] != "main") : ?>
            <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat stránku?', () => { $('#zos-about-delete').submit() })" class="button button-bd-info bd-round-symetric"><i class="fa fa-trash"></i> Smazat</button>
            <form id="zos-about-delete" method="post" action="/zos/app/about-delete" class="display-0">
                <input hidden type="text" name="token" value="2fe223c23363c90999ba93591ae662d5ce1c047820bed89b19563cc2ef9ce191"> <input hidden type="text" name="SID" value="6d21143359153fcc26c6b78e9387f9f3">
                <input hidden type='text' name='method' value='delete'>
                <input type="text" name="url" value="<?php echo $page['url'] ?>">
                <input type="submit">
            </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<div class="header-1 header-5-xsm header-3-sm header-2-md content-center t-zos t-bold pdy-2">
    <?php echo $page["title"] ?>
</div>

<div class="pd-2">
    <?php echo $page["_content"] ?>
</div>