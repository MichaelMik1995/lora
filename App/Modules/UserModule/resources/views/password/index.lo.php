<div class="pd-2 bgr-dark-2 bd-top-warning shadow-black-small">
    <i class="fa fa-exclamation-triangle t-warning"></i> UPOZORNĚNÍ: Po vyplnění formuláře a následném zpracování Vás odhlásíme. Poté se lze přihlásit již s nově nastaveným heslem
</div>

<div class="row mgy-4">
    <div class="column-2"></div>
    <div class="column-6">
        <div class="bgr-dark-2 pd-2 shadow-black-small">
            <div class="header-5 content-center t-bolder pdy-2">Změnit si heslo</div>
            <div class="">
                <form id="form-password-change" method="post" action="" class="">
                    @csrfgen
                    @request(update)

                    <input hidden name="uid" type="text" value="@useruid">

                    <div class="form-line">
                        <label for="current-password">Současné heslo: </label><br>
                        <input 
                            tabindex="1" 
                            id="current-password" 
                            name="current-password" 
                            type="password" 
                            validation="required,minchars1,maxchars128" 
                            class="width-30 width-100-xsm pd-2"
                        />
                        <div class="pd-1" valid-for="#current-password"></div>
                    </div>

                    <div class="row cols-2 cols-1-xsm">
                        <div class="column">
                            <label for="new-password">Nové heslo: </label><br>
                            <input 
                                tabindex="2" 
                                id="new-password" 
                                name="new-password" 
                                type="password" 
                                validation="required,minchars1,maxchars128" 
                                class="width-95 pd-2"
                            />
                            <div class="pd-1" valid-for="#new-password"></div>
                        </div>

                        <div class="column">
                            <label for="again-password">Znovu nové heslo: </label><br>
                            <input 
                                tabindex="3" 
                                id="again-password" 
                                name="again-password" 
                                type="password" 
                                validation="required,minchars1,maxchars128" 
                                class="width-95 pd-2"
                            />
                            <div class="pd-1" valid-for="#again-password"></div>
                        </div>
                    </div>

                    <div class="pdy-1">
                        <button tabindex="4" onClick="GUIDialog.dialogConfirm('Opravdu chcete změnit heslo? Pokud ano, tak Vás odhlásíme a vy se přihlásíte již s novým heslem', () => {$('#form-password-change').submit()})" type="button" class="button button-info"><i class="fa fa-key"></i> Změnit heslo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="column-2"></div>
</div>