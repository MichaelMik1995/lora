

<div class="pd-1 header-2">
    Dostupné moduly:
</div>

<row cols="5" cols-xsm="1" cols-sm="2" cols-md="3" cols-xlrg="8" class="pd-2">
    @foreach glob("./App/Modules/*") as $file @
        @php $module = str_replace("./App/Modules/","",$file) @
        @php $module_file = strtolower(str_replace("Module","",$module)) @

        @if $module != "bin" @
        <column-shrink class="pd-1 scale-xp-9-hover anim-all-normal">
            <div onClick="redirect('{{$module_file}}')" class="background-dark-2 background-dark-hover pd-2 bd-round-3 cursor-point">
                {{str_replace("Module","",$module)}}
            </div>
        </column-shrink>
        @endif

    @endforeach
</row>