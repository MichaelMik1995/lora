<div class="bd-round-2 bgr-dark-3 bd-dark-2 bd-top-create height-80">
        <!-- TOP menu -> buttons, hrefs -->
        <div class="pd-2 row cols-auto bd-bottom-dark-2">
                @foreach $hrefs as $href @
                <div redirect="admindev/app/{{ $href['href'] }}" class="column-shrink t-hover-create cursor-point bd-2 bd-dark-3">

                    <!-- Href icon -->
                    <div class="content-center header-6 pd-1">
                        <i class="fa fa-{{ $href['icon'] }} mgx-1"></i>

                    <!-- Href content -->  
                        {{ $href["name"] }}                   
                        @if $href['notification'] > 0 @
                            <span class="t-info"><sup>{{ $href['notification'] }}x</sup></span>
                        @endif

                    </div>
                </div>
                @endforeach
        </div>
        

        <!-- Dynamic content -->
        <div class="pd-3">
            @php $this->splitter_controll->loadView() @
        </div>
</div>