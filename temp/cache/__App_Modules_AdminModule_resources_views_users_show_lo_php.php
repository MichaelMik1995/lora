<div class="pd-1">

    <!-- HEADER Colored -->
    <div class="bgr-dark-2 bd-dark bd-1 content-center pdy-2"> 
        <div>
            <img class="height-128p" src="<?php echo asset('img/avatar/128/'.$user['uid'].'.png') ?>">
        </div>
        <div class="pdy-2 header-4 t-bolder">
            <?php echo $user['name'] ?>
        </div>
    </div>

    <!-- USER DATA INFO -->
    <div>
        <table rules="none" class="mgy-3 table table-medium">
            <tr class="bgr-dark-2 t-bolder">
                <td>Parametr</td>
                <td>Hodnota</td>
            </tr>

            <tr>
                <td>Jméno: </td>
                <td><?php echo $user['real_name'] ?></td>
            </tr>

            <tr>
                <td>Přijmení: </td>
                <td><?php echo $user['surname'] ?></td>
            </tr>

            <tr>
                <td>Email: </td>
                <td><?php echo $user['email'] ?></td>
            </tr>
        </table>
    </div>
</div>