##LORA je knihovna funkcí a utilit usnadňující práci vývoje webů a webových aplikací a je napsaná v PHP, kdy využívá další jazyky pro design a k přehlednosti kódu.##

LORA se začala psát v roce 2020 a její první verze byla 1.0. V této verzi byla funkční pouze kostra aplikace založena na architektuře MVC, tedy model, pohled a kontrolér. Dále byl vytvořen šablonový systém **lo.php**, který převzal některé z nejpoužívanějších funkcí v PHP. Postupem času se LORA začala plně rozvíjet a nyní je psaná ve verzi **3.2**

##Co dne může LORA nabídnout?##
LORA nyní může nabídnout celou kostru aplikace (SANDBOX), na kterou se vytvářejí jednotlivé moduly (*fórum, blog, kontakty* atd...) a tyto lze dále upravovat aniž by došlo k poškození kostry aplikace. Moduly plně využívají utilit, které kostra aplikace nabízí, a moduly s nimi spolupracují.

##Praktické využití LORY##

<ul>
<li>Po navrhnutí designu a jednotlivých funkcí si vytvořím jednotlivé moduly pomocí DEVELOPMENT utility AdminDev. Zde jednoduše pomocí GUI si navrhnu, co modul bude obsahovat.</li>
<li>Po vytvoření modulu následuje vytvoření tabulky v **databázi** (pokud je potřeba) a příprava *testovacích* dat. Tabulky, data a cizí klíče lze jednoduše vytvořit pomocí jediného **CLI** příkazu.</li>

<li>Vše je připraveno, nyní se v modulu zaregistrují URL adresy (cesta, request metoda, přístupy, načtený pohled atd., volaná metoda v kontroléru).</li>

<li>Nyní v kontroléru připravím metodu, do ní napíši co je třeba a připravím data pro šablonu.</li>

<li>V šabloně si napíšu HTML společně s direktivy a daty z kontroleru, a výstup se mi tiskne na obrazovku :)</li>
</ul>

##Další vlastnosti LORY##
Součástí LORY jsou pluginy (**ve vývoji**) usnadňující tvorbu převážně ve front-end části - **StylizeCSS** a **stylizeJS**.

**StylizeCSS** - zkompilovaný CSS soubor ze SASSu - obsahuje třídy pro geometrickou, vzhledovou úpravu. Dále obsahuje třídy pro práci s FLEX - web je responzivní.
**StylizeJS** - JS soubor využívající knihovnu JQuery, který obsahuje obecné funkce (redirect atd.). Pomocí StylizeJS lze používat tzv. L-Attributy, které lze použít pro události (event-toggle-class, listen-url, validator atd.).
**EasyText** - Jednoduchý textový editor, ve kterém lze text editovat v blocích, tyto jsou podobné HTML tagům a jsou pro web validní.

##Dostupnost LORY##
LORA prozatím není OPEN-SOURCE a není ve free verzi. Do Lory je ještě potřeba dopsat dokumentaci a nápovědu.