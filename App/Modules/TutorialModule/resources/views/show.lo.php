@auth admin @
    <div class="pd-2 content-right background-dark-3">
        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat tento příspěvek?', ()=>{$('#tutorial-delete').submit()})" class="button button-bd-error bd-round-symetric"><i class="fa fa-trash"></i> Smazat</button>
        <button redirect="tutorial/edit/{{ $tutorial['url'] }}" class="button button-warning bd-round-symetric"><i class="fa fa-edit"></i> Upravit</button>
    </div>

    <form hidden id="tutorial-delete" method="post" action="tutorial/delete/{{ $tutorial['url'] }}">
        @csrfgen
        @method delete @
        <input type="submit">
    </form>
@endauth

<div class="pd-2">
    <div class="header-3 content-center pdy-2">
        {{ $tutorial["title"] }}
    </div>
    <div class="background-dark-2 pd-2 bd-round-3">
        {{ $tutorial["_content"] }}
    </div>
    <hr>
    <div class="subheader-2 pdy-2">
        <div class="row cols-auto">
            @foreach $tutorial[":tags"] as $tag @
                <div class="column-shrink pd-1">
                    <div class="background-bd-warning pdy-1 pdx-2 bd-round-symetric background-warning-hover t-hover-dark-2 cursor-point">
                        #{{ $tag }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>