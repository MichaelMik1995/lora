<!-- Scheduler container LOGS -->
<div class=" pd-2 bgr-dark-2 bd-round-5 bd-dark">
    <div class="header-5 pd-1 pdx-2">Archivace Logů (Další archivace za <b class="t-info">{{ $arch_data["DAYS_REMAINING"] }}</b> dní):</div>
    <div class="row cols-3 cols-1-xsm">
        <div class="column pd-1">
            <div id="scheduler-card" class="bgr-dark-3 pd-2">
                <div>Poslední archivace</div>
                <div class="t-info">{{ $arch_data["LAST_LOG_DATE"] }}</div>
            </div>
        </div>
        <div class="column display-flex als-center content-center">
            <i class="fa fa-angles-right header-1"></i>
        </div>
        <div class="column pd-1">
            <div copy-attr="scheduler-card:class">
                <div>Příští archivace:</div>
                <div class="t-info">{{ $arch_data["LOG_NEXT_ARCHIVATION_DATE"] }}</div>
            </div>
        </div>
        <div class="column-10 content-center pdy-2">
            <button redirect="admin/app/scheduler-force-archive-log" class="button button-info"><i class="fa fa-rotate"></i> Archivovat nyní</button>
            <button type="button" onClick="$('#archivation-chng-interval').slideToggle(200)" class="button button-bd-info"><i class="fa fa-pen"></i> Změnit interval</button>
            <div id="archivation-chng-interval" class="display-0 pd-1 content-center">
                <form method="post" action="admin/app/scheduler-change-interval">
                    @csrfgen
                    @request(update)

                    <div class="element-group element-group-medium">
                        <input type="number" name="new-interval" min="1" max="365" value="{{ env('backup_log_days') }}">
                        <button type="submit" class="button button-info"><i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="column-10 pdy-2 bd-top-dark">
            <div class="content-center header-5 t-bold pdy-2">Historie archivací: </div>
            <div class="row pd-1">
                <div class="column-6 pd-1 bgr-dark">Zpráva: </div>
                <div class="column-4 content-right pd-1 bgr-dark">Log soubor</div>
                {{ $arch_data["LOG_HISTORY"] }}
            </div>
        </div>
    </div>
</div>