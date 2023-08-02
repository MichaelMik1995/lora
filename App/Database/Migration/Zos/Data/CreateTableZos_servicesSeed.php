<?php
namespace Loran\Seed;

use App\Database\MigrationFactory;
/**
 * Description of Schema
 *
 * @author michaelmik
 */
class CreateTableZos_servicesSeed 
{
    /**
     * Is hidden for migrate command?
     * @var bool $hidden
     */
    public bool $hidden = false;

    /**
     * Truncate table before creating new data?
     * @var bool $truncate_before_seed
     */
    public bool $truncate_before_seed = true;
    
    /**
     * Table for operation
     * @var string $table
     */
    private $table = "zos_services";
    
    public function createSeeds(MigrationFactory $factory)
    {           
        $factory->createSeed($this->table, [
            "name" => "Odchytové služby",
            "url" => "odchytove-sluzby",
            "short_description" => "Nabízíme odchytové služby psů, koček, holubů aj.
                                    Odchyty provádíme vždy tak, aby odchytávané zvíře bylo co nejméně stresováno, případně ohrožováno dalšími faktory.
                                    Odchyty provádíme pomocí vodítek, odchytové tyče, odchytového vaku, návnadové nebo dálkové narkotizace, 
                                    odchyty koček pomocí sklopce. V případě koček a holubů jsme schopni dle požadavků zadavatele a platné legislativy 
                                    provést komplexní soubor opatření, vedoucích ke snížení počtu těchto zvířat. Naprostou samozřejmostí je kontrola čipů 
                                    u odchycených zvířat a předání veškerých informací vhodným způsobem jak veřejnosti, tak dotčeným orgánům. Odchycené 
                                    zvíře je možné umístit v našem soukromém zařízení v Dalovicích. Prohlašujeme, že splňujeme veškeré legislativní 
                                    požadavky pro výkon této činnosti.",
            
            "content" => "Nabízíme odchytové služby psů, koček, holubů aj.
            Odchyty provádíme vždy tak, aby odchytávané zvíře bylo co nejméně stresováno, případně ohrožováno dalšími faktory.
            Odchyty provádíme pomocí vodítek, odchytové tyče, odchytového vaku, návnadové nebo dálkové narkotizace, 
            odchyty koček pomocí sklopce. V případě koček a holubů jsme schopni dle požadavků zadavatele a platné legislativy 
            provést komplexní soubor opatření, vedoucích ke snížení počtu těchto zvířat. Naprostou samozřejmostí je kontrola čipů 
            u odchycených zvířat a předání veškerých informací vhodným způsobem jak veřejnosti, tak dotčeným orgánům. Odchycené 
            zvíře je možné umístit v našem soukromém zařízení v Dalovicích. Prohlašujeme, že splňujeme veškeré legislativní 
            požadavky pro výkon této činnosti.",
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Záchranná služba pro zvířata",
            "url" => "zachranna-sluzba-pro-zvirata",
            "short_description" => "Pokud dojde u Vašeho zvířátka k razantnímu zhoršení zdravotního stavu, anebo k úrazu, 
            nedejbože k jiným závažným stavům jako je otrava, autonehoda, pokousání jiným psem atd. , jsme tu pro Vás. 
            Po telefonické dohodě co nejdříve přijedeme na Vámi zadanou adresu, poskytneme první pomoc a odvezeme Vás i 
            Vašeho zvířecího kamaráda k veterinárnímu lékaři. Volba veterinární ordinace je zcela na Vás, v případě potřeby 
            rádi poradíme, doporučíme a to s ohledem na potřebné přístrojové vybavení, 
            specializaci atd. K tomuto účelu slouží uzpůsobené vozy. Přeprava k veterinárnímu lékaři je závislá na provozní době 
            jednotlivých ordinací. V našem kraji není funkční nonstop pracoviště.",
            
            "content" => "Pokud dojde u Vašeho zvířátka k razantnímu zhoršení zdravotního stavu, anebo k úrazu, 
            nedejbože k jiným závažným stavům jako je otrava, autonehoda, pokousání jiným psem atd. , jsme tu pro Vás. 
            Po telefonické dohodě co nejdříve přijedeme na Vámi zadanou adresu, poskytneme první pomoc a odvezeme Vás i 
            Vašeho zvířecího kamaráda k veterinárnímu lékaři. Volba veterinární ordinace je zcela na Vás, v případě potřeby 
            rádi poradíme, doporučíme a to s ohledem na potřebné přístrojové vybavení, 
            specializaci atd. K tomuto účelu slouží uzpůsobené vozy. Přeprava k veterinárnímu lékaři je závislá na provozní době 
            jednotlivých ordinací. V našem kraji není funkční nonstop pracoviště.",
            
            "created_at" => time(),
            "updated_at" => time(),
        ]);

        $factory->createSeed($this->table, [
            "name" => "Potřebuji odchyt",
            "url" => "potrebuji-odchyt",
            "short_description" => "Potřebuji odchyt",
            "content"=> "Potřebuji odchyt",
            "type" => "1",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Chci pomoci",
            "url" => "chci-pomoci",
            "short_description" => "Chci pomoci",
            "content"=> "Chci pomoci",
            "type" => "1",
        ]);

        $factory->createSeed($this->table, [
            "name" => "Ztratil se mi pes",
            "url" => "ztrata-psa",
            "short_description" => "Ztratil se mi pes",
            "content"=> "ztratil se mi pes",
            "type" => "1"
        ]);

        $factory->createSeed($this->table, [
            "name" => "Ceník služeb",
            "url" => "cenik-sluzeb",
            "short_description" => "Ceník Služeb",
            "content"=> "Záchranná služba (tedy ta, která se využívá v případě nouze)
            Základní sazba ..……………………….………………………20Kč/km + cena za spotřební
            materiál, léčivé přípravky a ošetření, tyto položky jsou individuální dle povahy zákroku. Pokud zvolíte
            i cestu zpět z ošetření, ta již bude účtována v levnější sazbě a to 15,-Kč/km.
            Transport imobilního zvířete na nosítkách, v dece apod.………………………… příplatek 200,- Kč
            
            
            Přeprava zvířat – soukromé osoby
            Sazba ..…………………………………….……………… 15Kč/km
            Čekací doba: ………………………………………………………………30Kč/15 min
            Jednorázová podložka: ……………………………………………………………… 10,-Kč
            Transport imobilního zvířete pomocí nosítek, deky……………………………………………………… 200,-Kč
            Poplatek za čištění a desinfekci vozu je v rozmezí 60,- Kč (základ) až 1000,- Kč v případě nutnosti
            strojního čištění interiéru.
            
            *Objednatel nese plnou odpovědnost za škodu způsobenou zvířetem.
            
            
            Odchytová služba – obce s uzavřenou smlouvou
            
            
            Odchyt psů
            
            Sazba ………………………………………………………10Kč/km
            Odchyt pomocí návnady, vodítka …………………… 550,-Kč
            Odchyt pomocí distanční tyče ……………………… 850 – 1000,-Kč
            Odchyt pomocí sedace …………………………………1300,-Kč
            Odchyt pomocí narkotizace ………………………1500 – 2500Kč
            Odchyt pomocí sklopce ………… 500,-/den,1500,-/týden pronájmu plus náklady na přepravu sklopce (přeprava může být i vlastní)
            V cenách všech odchytů je již započtena kontrola čtečkou mikročipů a vyhledání mikročipu
            v dostupných evidencích.
            
            ​
            
            Odchyt koček
            Cenu jsme schopni sdělit dle místních podmínek (počet jedinců, náročnost na dopravu, atd.) V
            případě odchytu koček a to jak v režimu záchranné, tak odchytové služby je potřeba mít dopředu
            zajištěné i jejich umístění a to pro případ, že je nutná i následná péče po odchytu, případně převozu
            na veterinu. Následné umístění koček je dle ceníku cílového zařízení.
            
            
            
            Ubytování psů
            Ubytování odchycených psů ………………………… 150Kč/den
            Ubytování v naší stanici je pouze na tři dny po odchytu, následně se převáží odchycený pes do útulku, který si zajišťuje objednavatel.
            Odchyty pro obce bez smluvního vztahu neprovádíme!
            
            
            
            Pietní služby
            Sazba …………………………………………………….. 15,-Kč/km
            Poplatek za asanaci ………………………………………………………………27,- Kč/kg
            Poplatek za přepravní vak a desinfekci vozu ……..……. 200,-Kč
            Přeprava do pohřebních ústavů: po telefonické dohodě, v závislosti na vzdálenosti.
            
            
            
            Ostatní činnosti
            Práce posádky (vyprošťovací práce, lezecké práce, práce v infekčním prostředí, asistence při
            zpřístupňování prostor apod.)………….………………………………… 240,-/hod./osoba
            Vyžádaná administrativní činnost – poradenství, sepsání zpráv pro potřeby soukromých osob
            ………………………………….………………………………200,-/hod.
            Zpracování foto/video dokumentace z odchytu – zásahu na vyžádání soukromých osob
            ……………………………………………………………….. 500,-/hod.
            
            Pronájem odchytového vybavení
            Sklopec na kočky (typ1) ……………………100Kč/den + 1000Kč vratná kauce
            Sklopec na kočky (typ2) …………….… 150Kč/den + 1500Kč vratná kauce
            Sklopec na větší psy ………………. 300Kč/den, 1500Kč týden, vratná kauce 3000Kč
            *za případnou škoda a odcizení zodpovídá nájemce
            **odchyt toulavých a opuštěných zvířat smí provádět pouze osoba odborně způsobilá",
            "type" => "1"
        ]);
    }

    public function truncateTable(MigrationFactory $factory)
    {
        $factory->truncateTable($this->table);
    }
}

