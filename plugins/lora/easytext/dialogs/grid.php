<div class="easyText-Dialog_inner">   
    <div class="header-1 header-3-xsm header-2-xsm header-3-md content-center pdy-2">Vytvořit tabulku</div>     
    <div class="es_block content-center-sm">
        <div class=''>
            1
            <input style="cursor: pointer;" id="range-row-grid" type="range" min="1" max="10" value="5">
            5
        </div>
        <span id="range-count">5</span>
    </div>

    <div class="es_block">
        <div id="row" class="row cols-5">
            <?php for($i = 0; $i < 10; $i++) : ?>
                <div class="column-shrink pd-1">
                    <div class="bgr-dark mg-auto pd-3">Sample Text</div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <div class="es_footer content-center-xsm content-center-sm">
        <button class="button button-easytext" id="add-grid">Vložit Tabulku</button>
    </div>
</div>

<script>
    $("#range-row-grid").change(() => {
        var range_count = $("#range-row-grid").val();
        $("#range-count").text(range_count);

        $("#row").removeAttr("class").addClass("row cols-"+range_count);
    });
</script>