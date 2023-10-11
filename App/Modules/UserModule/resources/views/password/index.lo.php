<div class="row">
    <div class="column-2"></div>
    <div class="column-6">
        <div class="bgr-dark-2 pd-2 shadow-black-small">
            <div class="header-5 content-center t-bolder pdy-2">Změnit si heslo</div>
            <div class="">
                <form id="form-password-change" method="post" action="" class="content-center">
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
                            class="width-30 width-100-xsm"
                        />
                        <div class="pd-1" valid-for="#current-password"></div>
                    </div>

                    <div class="">
                        <label for="new-password">Nové heslo: </label><br>
                        <input 
                            tabindex="1" 
                            id="new-password" 
                            name="new-password" 
                            type="password" 
                            validation="required,minchars1,maxchars128" 
                            class="width-30 width-100-xsm"
                        />
                        <div class="pd-1" valid-for="#new-password"></div>
                    </div>

                    <div class="">
                        <label for="again-password">Znovu nové heslo: </label><br>
                        <input 
                            tabindex="1" 
                            id="again-password" 
                            name="again-password" 
                            type="password" 
                            validation="required,minchars1,maxchars128" 
                            class="width-30 width-100-xsm"
                        />
                        <div class="pd-1" valid-for="#again-password"></div>
                    </div>

                    <div class="pdy-1">
                        <button onClick="GUIDialog.dialogConfirm('Opravdu chcete změnit heslo? Pokud ano, tak Vás odhlásíme a vy se přihlásíte již s novým heslem', () => {$('#form-password-change').submit()})" type="button" class="button button-warning"><i class="fa fa-key"></i> Změnit heslo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="column-2"></div>
</div>