
<div class="row pdx-5 bgr-dark-2">
    <div class="column-2 display-flex">
        <div class="row cols-auto col-space-1 header-4 ali-center">
            <div id="admin-header-panel-column" class="column-shrink bgr-dark-3-hover pd-1 cursor-point bd-round-3 t-info"><i class="fa fa-plus"></i></div>
            <div redirect="admin/app/security" copy-attr="admin-header-panel-column:class"><i class="fa fa-shield"></i></div>
            <div redirect="admin/app/seo" copy-attr="admin-header-panel-column:class"><i class="fas fa-chart-bar"></i></div>
            <div class="column-shrink pd-1"> | </div>
            
        </div>
    </div>
    
    <div class="column display-flex column-justify-end ali-center">
        <span class="t-bolder">@username</span><p class="mgx-1"></p><img class="height-40p bd-round-circle" src="{{ asset('img/avatar/32/@useruid.png') }}" alt="admin-header-user-@useruid">
    </div>
</div>


<div class="row mgy-5">
    <div class="column-1">
        @foreach $hrefs as $href @
            <div redirect="admin/app/{{ $href['href'] }}" class="row pd-2 cursor-point t-info-hover bd-left-dark-2 mgy-2 bd-left-info-hover anim-all-fast bgr-dark-2-hover">
                <div class="column-2 column-10-xsm content-center-xsm"><i class="{{ $href['icon'] }}"></i></div>
                <div class="column column-10-xsm display-0-xsm">{{ $href['name'] }}</div>
                <div class="column-2 column-10-xsm content-right content-center-xsm"> 
                @if $href['notification'] > 0 @
                    <sup class="t-info">{{ $href['notification'] }}</sup>
                @endif
                </div>
            </div>
            @endforeach
    </div>
    <!-- Dynamic content -->
    <div class="column-9 pd-2">
        @php $this->splitter_controll->loadView() @
    </div>
    
</div>