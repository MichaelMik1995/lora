<div class='pd-1'>
    <div class="pd-1 mgy-2">
        <form method="post" action="/mshop/manager/advert-insert">
            @csrfgen
            <input placeholder="Aa..." type="text" name="advert-content" class="input-custom-2 width-40">
            <button type="submit" class="button-large button-custom-main-2"><i class="fa fa-plus-circle"></i> Přidat</button>
        </form>
    </div>
    @if !empty($adverts) @
        @php $i=1 @
        @foreach $adverts as $ad @
        <div class='row pd-1 mgy-2 background-dark-3 bd-round-3'>
            <div class='column-1 column-2-xsm'>
                <button event-toggle-class="click:display-1:display-0:#advert-edit-{{$ad['id']}}" class='button-circle button-warning width-40p height-40p'><i class="fa fa-edit"></i></button>
            </div>
            <div class='column column-8-xsm header-6'>
                <div>
                    #{{$i++}} = <span class="t-custom-1">{{$ad['_content']}}</span>
                </div>
                <div id="advert-edit-{{$ad['id']}}" class="display-0">
                    <form method="post" action="/mshop/manager/advert-update/{{$ad['id']}}">
                        @csrfgen
                        <input type="text" name="advert-update-content" value="{{$ad['content']}}" class="width-50 input-custom-2">
                        <button type="submit" class="button button-custom-main-1">Uložit</button>
                    </form>
                </div>
            </div>
            <div class="column-1">
                <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat reklamu?', () => {$('#advert-delete-{{$ad['id']}}').submit();})" class="button button-error bd-round-3"><i class="fa fa-trash"></i></button>
                <form id="advert-delete-{{$ad['id']}}" method="post" class="display-0" action="/mshop/manager/advert-delete">
                    @csrfgen
                    <input type="text" name="id" value="{{$ad['id']}}">
                    <input type="submit">
                </form>
            </div>
            
            
        </div>
        @endforeach
    @else
        <div class='header-3 content-center'>Prozatím zde není žádná reklama</div>
    @endif
</div>
