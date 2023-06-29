<div class="pd-2">
    <details>
        <summary class="header-6 pdx-2">Nový uživatel: </summary>


        <div class="bgr-dark-2 pd-2">
            <form method="post" action="/admin/app/user-create">
                <input hidden type="text" name="token" value="538fb255d54af89e92b41f7ba41b2f0398771d0fb563701e146f7040854f618b"> <input hidden type="text" name="SID" value="315cd74ea61c616ae1f776cf144472c1">
                <input hidden type='text' name='method' value='insert'>

                <div class="mgy-2">
                    <label for="user-name" class="t-first-upper"><?php echo lang('user_name') ?></label><br>
                    <input type="text" id="user-name" name="user-name" class="input-dark pd-2 width-15 width-75-xsm" validation="required,maxchars64">
                    <div class="pd-1" valid-for="#user-name"></div>
                </div>

                <div class="row width-30 width-100-xsm">
                    <div class="column-5">
                        <label for="user-real-name" class="t-first-upper"><?php echo lang('user_real_name') ?></label><br>
                        <input 
                            type="text" 
                            id="user-real-name" 
                            name="user-real-name" 
                            class="input-dark pd-2 width-100" 
                            validation="required,maxchars64"
                            placeholder="<?php echo lang('placeholder_real_name') ?>"
                        >
                        <div class="pd-1" valid-for="#user-real-name"></div>
                    </div>
                    <div class="column-5">
                        <label for="user-surname" class="t-first-upper"><?php echo lang('user_surname') ?></label><br>
                        <input 
                            type="text" 
                            id="user-surname" 
                            name="user-surname" 
                            class="input-dark pd-2 width-100" 
                            validation="required,maxchars64"
                            placeholder="<?php echo lang('placeholder_real_surname') ?>"
                        >
                        <div class="pd-1" valid-for="#user-surname"></div>
                    </div>
                </div>

                <div class="mgy-2">
                    <label for="user-email" class="t-first-upper"><?php echo lang('user_email') ?></label><br>
                    <input type="text" id="user-email" name="user-email" class="input-dark pd-2 width-30 width-75-xsm" validation="required,maxchars64,email" placeholder="example@gmail.com">
                    <div class="pd-1" valid-for="#user-email"></div>
                </div>

                <div class="mgy-2">
                    <label for="user-password" class="t-first-upper"><?php echo lang('user_password') ?></label><br>
                    <input type="text" id="user-password" name="user-password" class="input-dark pd-2 width-30 width-75-xsm" value="<?php echo $password ?>">
                </div>
                
                <div class="mgy-2">
                    <button class="button button-info bd-round-3"><i class="fa fa-plus-circle"></i> Přidat</button>
                </div>
            </form>
        </div>
    </details>
</div>

<div class="row cols-6 cols-2-xsm">
    <?php if(!empty($users)) : ?>
        <?php foreach($users as $user) : ?>
        <div class="column-shrink pd-2">
            <?php if($user['is_admin'] == true) : ?>
                <?php $border = "info" ?>
            <?php else : ?>
                <?php $border = "dark-2" ?>
            <?php endif; ?>
            <div class="bgr-dark-2 pd-1 bd-top-<?php echo $border ?> bd-3">
                <div class="content-center">
                    <img class="height-128p" src="<?php echo asset('img/avatar/128/'.$user['uid'].'.png') ?>" alt="admin-user-card-<?php echo $user['uid'] ?>">
                </div>
                <div id="<?php echo $user['uid'] ?>" class="content-center pdy-2">
                    <div class="t-bolder t-info"><?php echo $user["name"] ?></div>
                    <div class="subheader-3"><?php echo $user['uid'] ?></div>
                </div>
                <div class="row header-6">
                    <div class="column">
                        <?php if($user['is_admin'] == true) : ?>
                            <i title="Uživatel je administrátor webu" class="fa fa-lock t-info pd-1"></i>
                        <?php else : ?>
                            <i title="Uživatel je běžným členem" class="fa fa-unlock pd-1"></i>
                        <?php endif; ?>
                        <i redirect="admin/app/user-show/<?php echo $user['uid'] ?>" class="fa fa-info-circle t-info-hover cursor-point bgr-dark-3-hover bd-round-3 pd-1"></i>     
                        
                        
                    </div>
                    <div class="column content-right">
                        <?php if($user['email_verified_at'] > 0) : ?>
                            <i title="Uživatel ověřen dne: <?php echo DATE('d.m.Y H:i:s', $user['email_verified_at']) ?>" class="fa fa-check-circle t-success pd-1"></i>
                        <?php else : ?>
                            <i redirect="admin/app/user-verify/<?php echo $user['uid'] ?>" class="fa fa-close t-error pd-1"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>   
        </div>
        <?php endforeach; ?>
    <?php else : ?>
    <div class="t-error">Nebyl nalezen žádný uživatel</div>
    <?php endif; ?>
</div>
