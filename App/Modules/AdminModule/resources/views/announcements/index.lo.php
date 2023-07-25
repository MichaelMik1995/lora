<div class="pd-2">
    <form method="post" action="admin/app/announcement-insert">
        @csrfgen
        @request(insert)

        <div class="form-line">
            <label for="title">Titulek oznámení: </label><br>
            <input required type="text" name="title" id="title" placeholder="Název titulku" validation="required,maxchars128" class="input-dark pd-2 width-30">
            <div valid-for="#title" class="pd-1"></div>
        </div>

        <div class="form-line">
            {{ $editor }}
        </div>
    </form>
</div>

<div>
@if !empty($all) @
    @if $pages > 1 @
        <div class="pd-2">
            @php for($i = 1; $i <= $pages; $i++):  @
                <i redirect="admin/app/announcements/{{ $i }}" class="fa fa-circle t-info"></i>
            @php endfor; @
        </div>
    @endif

    <div class="row cols-4">
        @foreach $all as $announ @
            <div class="column-shrink pd-1">
                <div class="bgr-dark-2 bd-dark bd-1 bd-round-3 pd-2">
                    <div class="t-bolder header-6 t-info"><i class="fa fa-bullhorn mgx-1"></i> {{ $announ['title'] }}</div>
                    <div class="pdx-1 subheader-3"><i class="fa fa-calendar"></i> {{ real_date($announ["created_at"]) }}</div>
                    <div class="pdx-1 pdy-2">
                        {{ $announ["_content"] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="header-3 t-warning t-bolder content-center">Nebylo nalezeno žádné oznámení!</div>
@endif
</div>
