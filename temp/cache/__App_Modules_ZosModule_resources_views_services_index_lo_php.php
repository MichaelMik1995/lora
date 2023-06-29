<div class="t-big-2 header-1-xsm t-zos t-bold content-center pdy-2">
    Naše služby
</div>

<?php if(in_array("admin", [''])) : ?>
<div class="pdy-1 content-center">
    <button redirect="zos/app/service-create" class="button button-info bd-round-symetric"><i class="fa fa-plus-circle"></i> Přidat službu</button>
</div>
<?php endif; ?>

<div class="pd-1 content-center">
    <button redirect="zos/app/service-show/cenik-sluzeb" class="button button-zos"><i class="fa fa-coins"></i> <span class="display-0-xsm">Ceník služeb</span></button>
</div>

<div class="mgy-2">
    <?php foreach($services as $service) : ?>
    <?php if($service["type"] != "1") : ?>
        <div class="row mgy-5">

            <!-- Left Image -->
            <div class="column-2 column-10-xsm content-center-xsm">
                <img src="<?php echo modasset('img/zachranka.png') ?>">
            </div>

            <!-- Text -->
            <div class="column-6 column-10-xsm">
                <div class="content-center header-2 t-bolder">
                    <span redirect="zos/app/service-show/<?php echo $service["url"] ?>" class="t-hover-warning cursor-point"><?php echo $service["name"] ?></span>
                </div>
                <div class="pdy-2 content-justify">
                    <?php echo $service["short_description"] ?>
                </div>
            </div>

            <!-- Right Image -->
            <div class="column-2 column-10-xsm display-0-xsm">
                <img src="<?php echo modasset('img/zs-dalovice.png') ?>">
            </div>
        </div>
    <?php endif; ?>
    <?php endforeach; ?>

    <div class="mgy-2 bd-top-error bd-1 pdy-3">
        <div class="t-error header-1 content-center">
            Co neprovádíme?
        </div>
        <div class="pd-2 content-justify">
            Neprovádíme odchyty a umístění volně žijících zvířat, neprovádíme odchyty toulavých zvířat na základě oznámení veřejnosti, 
            neprovádíme domácí euthanasie bez přítomnosti veterinárního lékaře, neprovádíme vyhledání zaběhlých zvířat, 
            a to ani pomocí jiného psa ani pomocí mikročipu – mikročip skutečně neslouží jako GPS lokátor. 
            Také není možno k nám zvíře umístit, protože máte například alergii, 
            narodilo se vám dítě, anebo už jej jednoduše nechcete. 
        </div>
    </div>

    
</div>