<div class="mgy-2 t-big-3 header-2-xsm header-2-sm header-2-md t-bold t-zos content-center">
    Záchranná stanice pro psy:<br> „U přednosty Avájeka“
</div>

<div class="header-5 header-6-xsm header-6-sm header-6-md content-justify">
    Dne 1.4.2014 byl zahájen vznik a provoz naší malé záchranné stanice pro psy v obci Dalovice. 
    Záchranné – k jejím obyvatelům vyjíždíme jako záchranná služba pro zvířata a stanice – 
    nachází se přímo na železniční stanici.
</div>

<div class="header-5 header-6-xsm header-6-sm header-6-md content-justify pdy-3">
    Nemá tedy nic společného se záchrannými stanicemi pro volně žijící živočichy. Stanice se nachází přímo v nádražní budově a na přilehlém pozemku v obci Dalovice.
    K dispozici má malý pozemek, na kterém jsou dva venkovní kotce. Dále se skládá ze zázemí v budově. V současné době má k ubytování také jednu nevytápěnou místnost a dvě malé místnůstky s možností zimního přitápění pro ty nemocné, poraněné a zimomřivé.
    Stanice vznikla z potřeby okamžitého umístění psů, ke kterým vyjíždíme v rámci záchranné a odchytové služby do terénu.      Tato stanice neplní a ani nemůže plnit funkci klasického útulku. Slouží pouze ke krátkodobému umístění. Jsou zde krátkodobě umístěni odchycení psi ze smluvních obcí.
    Dále je tato stanice určena pro psy, kteří se k nám dostali v horším zdravotním stavu, snažíme se jim zde poskytnout individuální a svým způsobem nadstandardní péči, která někdy bývá pro klasické útulky k ohledem na množství svěřenců, časovou náročnost a neochotu financovat dražší péči z obecních a městských rozpočtů problematickou.
    Děkujeme, že jim pomáháte spolu s námi, protože i Vaší zásluhou (ať už finanční, materiální, někdy i formou dočasné péče) jim můžeme nabídnout něco navíc.
</div>

<div class="row">
    <div class="column-3 column-10-xsm content-center-xsm pd-5">
        <div>
            <button redirect="zos/app/station-animals-show/domov-hledaji" class="button-large button-bd-zos">Domov hledají <i class="fa fa-chevron-right"></i></button>
        </div>

        <div class="mgy-10">
            <button redirect="zos/app/station-animals-show/v-leceni" class="button-large button-bd-zos">V léčení <i class="fa fa-chevron-right"></i></button>
        </div>

        <div class="mgy-10">
            <button redirect="zos/app/station-animals-show/nasli-domov" class="button-large button-bd-zos">Našli domov <i class="fa fa-chevron-right"></i></button>
        </div>
    </div>

    <div class="column column-10-xsm display-0-xsm">
        <img src="<?php echo modasset('img/zs-dalovice.png') ?>" class="mg-auto">
    </div>
</div>

<?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>
<div class="bd-top-info bd-bottom-info bd-1">
    <div class="t-info t-italic content-center">Admin:</div>
    <div class="mgy-2">
        <button title="Ukázat všechny statusy" redirect="zos/app/station-statuses" class="button-circle width-32p height-32p button-info"><i class="fa fa-tag"></i></button>
        <button title="Vytvořit nový přírustek" redirect="zos/app/station-animal-create" class="button-circle width-32p height-32p button-info"><i class="fa fa-plus-circle"></i></button>
    </div>
</div>
<?php endif; ?>

<div class="pd-2 background-dark-3 bd-round-3 mgy-2">
    <div class="header-5">Další statusy:</div>
    <div class="row cols-5 cols-2-xsm cols-4-sm cols-6-md">
        <?php foreach($statuses as $status) : ?>
            <?php if($status['slug'] != "nasli-domov" && $status['slug'] != "domov-hledaji" && $status['slug'] != "v-leceni") : ?>
            <div class="column-shrink pd-1">
                <button redirect="zos/app/station-animals-show/<?php echo $status['slug'] ?>" class="button button-bd-zos"><?php echo $status['name'] ?> <i class="fa fa-chevron-right"></i></button>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>