<div class="header-1 t-warning t-bold pdy-3 content-center">
    <?php echo $service["name"] ?>
</div>

<?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
<div class="content-right pd-2">
    <button redirect="zos/app/service-edit/<?php echo $service['url'] ?>" class="button button-bd-info bd-round-symetric"><i class="fa fa-edit"></i> Upravit</button>
    <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat službu?', () => { $('#delete-service').submit() }) " class="button button-bd-info bd-round-symetric"><i class="fa fa-trash"></i> Smazat</button>
</div>


<form id="delete-service" method="post" action="zos/app/service-delete" class="display-0">
    <input hidden type="text" name="token" value="456dbffeab73f389f1ab7f5e0f0763547e08b69bef4875e6a771bb0702d8df71"> <input hidden type="text" name="SID" value="de32740e3bfb99416db8812e2edec116">
    <input hidden type='text' name='method' value='delete'>

    <input type="text" name="url" value="<?php echo $service['url'] ?>">
    <input type="submit">
</form>
<?php endif; ?>

<div class="pd-2 content-justify">
    <?php echo $service["_content"] ?>
</div>

