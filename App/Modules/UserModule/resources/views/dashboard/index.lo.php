
@if !empty($newest_announcements) @
<div id="announcement-block" class="bd-round-3">
    <div id="a-header" class="header-5 t-bolder pdy-1 pdx-2 content-center">{{ $announcement["title"] }}</div>
    <div class="t-italic subheader-3 pdx-3">
        <img id="a-author" src="{{ asset('img/avatar/32/'.$announcement['author'].'.png') }}"> <i class="fa fa-calendar"></i> <span id='a-date'>{{ real_date($announcement['updated_at']) }}</span>
    </div>
    <div id="a-content" etext-event="compile" class="pdy-3 pdx-3">
        {{ $announcement['_content'] }}
    </div>
    <div class="pdy-2 pdx-3 bgr-dark">
        Zpráva pro: <span class="t-info">Všechny</span>
    </div>
    
</div>
<div class="row row-center-lrg row-center-xlrg cols-auto pdy-2 col-space-3">
    @php $i = 0; @
    @foreach $newest_announcements as $na @
    @php $id = $i++ @
    <div class="column-shrink">
        <i
            id="announ-href-{{ $na['url'] }}"
            title="{{{ $na['title'] }}}" 
            class="fa fa-circle t-dark header-5 mgx-1 t-light-hover cursor-point announcement-href" >
        </i>
        <script>
            
            $("#announ-href-{{ $na['url'] }}").click((e) => {
                e.preventDefault();
                
                $("#announcement-block").hide(300, function()
                {
                    $("#a-header").text('{{ $na['title'] }}');
                    $("#a-author").attr("src", '{{ asset('img/avatar/32/'.$na['author'].'.png') }}');
                    $("#a-date").text('{{ real_date($na['updated_at']) }}');
                    
                    $("#a-content").html('{{ str_replace(["'", '"', "[Br]"], ['\"', '\"', '<br>'], $na['content']) }}');
                    EText.compile($("#a-content"));
                }).show(200, function(){
                    $(".announcement-href").removeClass("t-info").addClass("t-dark");
                    $("#announ-href-{{ $na['url'] }}").removeClass("t-dark").addClass("t-info");
                });
            });
        </script>
        
    </div>
    @endforeach
</div>
@endif



<div class="row">
    <div class="column-5 pd-2">
        Dasshboard
    </div>

    <div class="column-5 pd-2">
        <!-- Widget DATE -->
    </div>
</div>

<script>

    $(document).ready(() => {
        $(".announcement-href:eq(0)").removeClass("t-dark").addClass("t-info");
    });

    function updateAnnouncementTable(id, title, author, date, content)
    {
        console.log(id);
        $("#announcement-block").hide(300, function()
        {
            $("#a-header").text(title);
            $("#a-author").attr("src", author);
            $("#a-date").text(date);
            $("#a-content").html(content);
        }).show(200, function(){
            $(".announcement-href").removeClass("t-info").addClass("t-dark");
            $(".announcement-href:eq(" +id+ ")").removeClass("t-dark").addClass("t-info");
        });
        
    }
</script>