<link rel='stylesheet' type='text/css' href='{host}/public/css/stylize.css'>
<page class="pd-2">
        <div class="header-5 content-right t-bolder">Faktura - Daňový doklad č. {id}</div>
        <div class="content-right t-italic">Evidenční číslo: <span class='t-bolder'>{order-id}</span></div>
        
        <div class="row mgy-2">
            <div class="column-3">
                <img src="{host}/public/img/logo/main_logo.png" class="height-128p">
            </div>
            
            <div class="column-7 content-right">
                <div class="row"><div class="column-7 content-right">Datum vystavení:</div><div class="column">{order-created-at}</div></div>
                <div class="row"><div class="column-7 content-right">Datum plnění: </div><div class="column">{order-created-at}</div></div>
                <div class="row"><div class="column-7 content-right">Datum splatnosti: </div><div class="column">{order-created-at}</div></div>
                <div class="row"><div class="column-7 content-right">Vystavil: </div><div class="column t-bolder">{company}</div></div>
                <hr class="mgy-1">
                <div class="row"><div class="column-7 content-right">Forma úhrady:</div><div class="column"> {delivery-type}</div></div>
                <div class="row"><div class="column-7 content-right">Variabilní symbol: </div><div class="column"><span class="t-bolder">{order-id}</span></div></div>
                <div class="row"><div class="column-7 content-right">Číslo bankovního účtu: </div><div class="column"><span class="t-bolder">{bank-account}</span></div></div>
            </div>
        </div>
        
        <hr class="mgy-2">
        <div class="row mgy-2">
            <div class="column">
                <div class="header-5 t-bold t-underline">Dodavatel</div>
                <div class="t-bolder">
                    GOTA Custom s.r.o<br>
                    Sokolovská 1578<br>
                    356 05 Sokolov<br>
                    IČO: 12345678<br>
                    DIČ: 23456789
                </div>
            </div>
            
            <div class="column content-right">
                <div class="header-5 t-bold t-underline">Odběratel</div>
                
                <div class="t-bolder">
                    {customer-name}<br>
                    {customer-address}<br>
                    {customer-post-code} {customer-city}
                </div>
            </div>
        </div>
        
        <div class="mgy-3 row pd-1 pdy-1 background-dark t-bolder subheader-3">
            <div class="column-1">Počet</div>
            <div class="column-2">Popis</div>
            <div class="column-1 content-center">Cena</div>
            <div class="column-1 content-center">Sazba DPH</div>
            <div class="column-2 content-center">Zákl. DPH</div>
            <div class="column-1 content-center">DPH</div>
            <div class="column content-center">Celkem</div>
        </div>
        <hr>
        
        {products-table}

        <hr>
        <div class="content-right mgy-1">
            Celkem za položky: <span class="t-bold">{products-price} Kč</span>
        </div>
        
        <div class="content-right header-5">
            Poštovné: <span class="t-bold">{delivery-price} Kč</span>
        </div>
        
        <div class="content-right header-3 t-bold mgy-2">
            Celkem k úhradě: {total} Kč
        </div>
</page>
