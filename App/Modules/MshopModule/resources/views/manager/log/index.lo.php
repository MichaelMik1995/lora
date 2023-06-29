<div class="pd-1-xsm pd-2 background-dark-3 bd-round-3 width-75 width-100-xsm height-512p overflow-auto mgx-20 mgx-0-xsm">
    
    @php $log = array_reverse($log) @
    @foreach $log as $line @
        @if !empty($line) @
            <div class="row cols-1-xsm background-dark-2 mgy-1 pd-2 bd-round-3">
                <div class="column-2 t-custom-1 content-center-xsm">
                    {{DATE("d.m.Y H:i:s", $line["DATE"])}}
                </div>
                <div class="column-2 content-center-xsm">
                    {{$line["TYPE"]}}
                </div>
                <div class="column-6 content-right content-justify-xsm mgy-2-xsm">
                    {{$line["MESSAGE"]}}
                </div>
            </div>
        @endif
    @endforeach
</div>