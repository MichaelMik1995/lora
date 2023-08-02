<h1>LORA je knihovna funkcí a utilit, napsaná převážně v jazyce PHP, usnadňující práci vývoje webů a webových aplikací, kdy využívá další jazyky pro design a k přehlednosti kódu.</h1>

LORA se začala psát v roce 2020 a její první verze byla 1.0. V této verzi byla funkční pouze kostra aplikace založena na architektuře MVC, tedy model, pohled a kontrolér. Dále byl vytvořen šablonový systém **lo.php**, který převzal některé z nejpoužívanějších základních funkcí v PHP. Postupem času se LORA začala plně rozvíjet a nyní je psaná ve verzi **3.2**. **Lora je určena hlavně pro začátečníky, kteří se začínají věnovat systému MVC a programování v PHP obecně**.

<h3>Co dnes může LORA nabídnout?</h3>
LORA nyní může nabídnout celou kostru aplikace (SANDBOX), na kterou se instalují jednotlivé moduly (*fórum, blog, kontakty* apod...) a tyto lze dále upravovat, aniž by došlo k poškození samotné kostry aplikace. Moduly plně využívají a spolupracují s utility, které kostra aplikace nabízí.

<h3>Praktické využití LORY</h3>

<ul>
<li>Po navrhnutí designu a jednotlivých funkcí si vytvořím jednotlivé moduly pomocí DEVELOPMENT utility AdminDev. Zde jednoduše pomocí GUI si navrhnu, co modul bude obsahovat.</li>
<li>Po vytvoření modulu následuje vytvoření tabulky v **databázi** (pokud je potřeba) a příprava *testovacích* dat. Tabulky, data a cizí klíče lze jednoduše vytvořit pomocí jediného **CLI** příkazu.</li>

<li>Vše je připraveno, nyní se v modulu zaregistrují URL adresy (cesta, request metoda, přístupy, načtený pohled atd., volaná metoda v kontroléru).</li>

<li>Nyní v kontroléru připravím metodu, do ní napíšu co je třeba a připravím data pro šablonu.</li>

<li>V šabloně si napíšu HTML společně s direktivy a daty z kontroleru, a výstup se mi tiskne na obrazovku :)</li>
</ul>

<h3>Další vlastnosti LORY</h3>
Součástí LORY jsou pluginy (**ve vývoji**) usnadňující tvorbu převážně ve front-end části - **StylizeCSS** a **stylizeJS**.

**Příklady použitých pluginů v Loře**:
**StylizeCSS** - zkompilovaný CSS soubor ze SASSu - obsahuje třídy pro geometrickou a vzhledovou úpravu. Dále obsahuje třídy pro práci s FLEX - web je responzivní.
**StylizeJS** - JS soubor využívající knihovnu JQuery, který obsahuje užitečné funkce (redirect atd.). Pomocí StylizeJS lze používat tzv. **L-Attributy**, které lze použít pro události (*event-toggle-class*, *listen-url*, *validator* atd.).
**EasyText** - Jednoduchý textový editor, ve kterém lze text editovat v blocích, tyto jsou podobné HTML tagům a jsou pro web validní.

<h3>Dostupnost LORY</h3>
LORA prozatím **není** OPEN-SOURCE a není ve free verzi. Do Lory je ještě potřeba dopsat dokumentaci a nápovědu.

<h3>TRELLO Roadmap Lora Framework</h3>
<a href="https://trello.com/b/KyPUM9C4/lora-sandbox">https://trello.com/b/KyPUM9C4/lora-sandbox</a>