<div class="row">
    <div class="column-2"></div>
    <div class="column">
        <div class="document pd-3">
            <div class="mgy-2">
            <div id="document-header" class="header-3 pdy-1 t-warning t-bolder content-center-xsm header-5-xsm">Registrací do systému souhlasíte s těmito pravidly:</div>
            <ul style="list-style: square;">
                <li>Vaše jméno by <b>nemělo obsahovat speciální znaky (např. "_" nebo "$")</b></li>
                <li>Vaše jméno by dále <b>nemělo obsahovat mezery</b></li>
                <li>Email při registraci musí být platný (Pokud není, nelze ověřit uživatele nebo později obnovit zapomenuté heslo atd.)</li>
                <li>Heslo by mělo obsahovat <b>min. 8 znaků, 1 velké písmeno a 1 číslo</b></li>
                <li>Heslo zadejte takové, <b>které nikde jinde nemáte zaregistrované!</b></li>
                <li>Mějte na paměti, že <b>špatně zadané údaje ovlivní komfort Vašeho procházení webu</b></li>
            </ul>
            </div>
            
            <div class="mgy-2">
            <div copy-attr="document-header:class">Registrací do systému souhlasíte dále s těmito pravidly:</div>
            <ul>
                <li>Jeden uživatel má pouze jeden profilový účet</li>
                <li><b>Uživatel je povinen chovat se podle dobrých společenských mravů a konvencí</b></li>
                <li><b>Na webu jsou zakázány veškeré urážky nebo chování odporujícím dobrým mravům a zákonům České Republiky</b></li>
                <li>Je zakázána reklama nebo zveřejňování IP adres jiných serverů</li>
                <li>Příspěvky nepsat pouze velkým písmem (např.: se zapnutým CAPSLOCKem)</li>
                <li>Příspěvky a komentáře by měli být v souladu s českým pravopisem</li>
                <li><b>Pokud je během procházení webu nalezena chyba, je uživatel povinen na chybu upozornit administrátora webu</b></li>
                <li>Nezatěžovat web rychle jdoucími po sobě opakovanými funkcemi (např.: SPAM)</li>
                <li><b>Nevkládat obrázky odporující pravidlům webu</b></li>
                <li>Zaregistrovaný uživatel by měl navštívit web min. 1 za půl roku. <b>Po půl roce neaktivity bude uživatel nenávratně smazán</b></li>
            </ul>
            </div>
            
            <div class="mgy-2">
            <div copy-attr="document-header:class">Co vše webová stránka {{ $web_name }} shromažďuje za údaje?</div>
            <ul>
                <li>Základní údaje: jméno, heslo-otisk, email</li>
                <li><b>IP adresu uživatele</b> (pro případ nevhodného chování je adresa IP banována)</li>
                <li>Systém dále vygeneruje tyto údaje: datum první registrace, datum posledního přihlášení, členský level, typ členství</li>
                <li>Pro funkci automatického přihlášení uživatele web shromažďuje tzn.: <b>COOKIES (uživatelské jméno, stav přihlášení pro autologin, uživatelské ID, vygenerovaný klíč pro autologin)</b></li>
                <li>Uživatelský status (online, offline atd.), celkový počet napsaných příspěvků, komentářů atd.</li>
                <li>Napsané příspěvky, vytvořená témata</li>
                <li>Počet hodnocených příspěvků</li>
                <li>Systém LOGuje shora uvedenou aktivitu uživatele mimo textů příspěvků registrovaných uživatelů</li>
            </ul>
            </div>
            
            <div class="mgy-2">
            <div copy-attr="document-header:class">Jaká práva má administrátor webové stránky?</div>
                <div class="t-bolder pd-1">
                    Pokud administrátor dostane podnět od ostatních uživatelů nebo redaktorů, že daný uživatel porušuje
                    pravidla nebo povinnosti uvedené zde v pravidlech, je admin oprávněn:
                </div>
                <ul>
                    <li>Zkontrolovat LOG systému</li>
                    <li>Zkontrolovat veškeré soukromé zprávy daného uživatele</li>
                    <li>Zkontrolovat vložené obrázky, zdali odpovídají pravidlům webu</li>
                    <li>Upozornit uživatele na porušování pravidel nebo povinností webu</li>
                    <li>Pokud daný uživatel bude i po upozornění administrátorem dále porušovat pravidla a povinnosti webu, může být smazán nebo zabanován</li>
                </ul>
            <br>
            <ul>
                <li><b>Pokud nesouhlasíte s výše uvedenými pravidly a povinnostmi, <span class='t-warning'>NEREGISTRUJTE SE</span></b></li>
            </ul>
            </div>
        </div>
        
        <div class="pdy-2">
            <button onclick="history.back()" class="button button-info" id="close_document"><i class="fa fa-chevron-left"></i> Zpět</button>
            <button class="button button-bd-info" id="print_document"><i class="fa fa-print"></i> Tisknout</button>
        </div>
    </div>

    <div class="column-2"></div>
</div>

<script>
$("#close_document").click(function(){
    $("#reg_doc").toggle(200).val("");
});    

$("#print_document").click(function(){
  var divToPrint=$('.document').html();
  var newWin=window.open('','Print-Window');
  
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');
  newWin.document.close();
    setTimeout(function(){newWin.close();},10);
});
</script>
