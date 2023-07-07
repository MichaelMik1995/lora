<div class="row cols-auto background-dark bd-round-2">
    <div id="column-modules-menu" redirect="admindev/app/module-create" class="column-shrink pdy-2 pdx-4 scale-11-hover anim-all-fast background-dark-3-hover bd-right-dark-3 cursor-point">
        <a id="column-modules-menu-href" class="t-light"><i class="fa fa-plus-circle"></i> Nový modul</a>
    </div>

    <div copy-attr="column-modules-menu:class" redirect="admindev/app/module-templates">
        <a copy-attr="column-modules-menu-href:class"><i class="fa fa-file"></i> Šablony</a>
    </div>
</div>

<div class="pd-2 pdx-4 header-4 t-bold">
    Dostupné moduly:
</div>

<div class="pd-2">
    <div class="row cols-4 cols-1-xsm">
        @foreach $modules as $module @

            <div class="column-shrink pd-2">
                <div class="bd-dark background-dark-2 bd-2 bd-round-3">
                    <div class="t-bold bd-bottom-dark pd-2">
                        <div redirect="{{ strtolower($module["name"])  }}" class="header-6 pdy-1 t-dark t-info">
                            {{ $module["name"] }}
                        </div>
                        <div class="subheader-3 pdy-2">
                            {{ $module["path"] }}
                        </div>
                    </div>

                    <div class="content-right pd-2">
                        <button redirect="admindev/app/module-show/{{ strtolower($module["name"]) }}" class="button button-bd-info bd-round-symetric mgx-1"><i class="fa fa-eye"></i></button>
                        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat modul?', () => {redirect('admindev/app/module-delete/{{ $module['name'] }}')})" class="button button-bd-error bd-round-symetric"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>