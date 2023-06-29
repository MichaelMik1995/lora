
<div class="row cols-auto background-dark bd-round-2">
    <div class="column-shrink pdy-2 pdx-4 scale-11-hover anim-all-fast background-dark-3-hover bd-right-dark-3">
        <a href="admindev/app/module-create" class="t-light"><i class="fa fa-plus-circle"></i> Nový modul</a>
    </div>
</div>

<div class="pd-2 pdx-4 header-4 t-bold">
    Dostupné moduly:
</div>

<div class="pd-2">
    <div class="row cols-4 cols-1-xsm">
        <?php foreach($modules as $module) : ?>
            <div class="column-shrink pd-2">
                <div class="bd-dark background-dark-2 bd-2 bd-round-3">
                    <div class="t-bold bd-bottom-dark pd-2">
                        <div class="header-6 pdy-1 t-dark t-info">
                            <?php echo $module["name"] ?>
                        </div>
                        <div class="subheader-3 pdy-2">
                            <?php echo $module["path"] ?>
                        </div>
                    </div>

                    <div class="content-right pd-2">
                        <button class="button button-bd-light bd-round-symetric mgx-1"><i class="fa fa-eye"></i></button>
                        <button class="button button-bd-light bd-round-symetric"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>