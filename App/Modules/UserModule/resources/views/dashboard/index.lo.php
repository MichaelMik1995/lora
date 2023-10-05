<div class="pd-2 pdy-3 bd-bottom-dark">
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
</div>

<div class="">
    <row cols="3" cols-xsm="1" child-class="pd-2">
        <column>
            <!-- USER CARD -->
            <div class="bgr-dark-2 pdy-2 shadow-black-small">
                <div class="content-center">
                    <img src="{{ asset('img/avatar/128/@useruid.png') }}" class="bd-round-cirle">
                </div>
                <div class="pdy-2 header-4 content-center">@username</div>
            </div>
        </column>
        <column>
            <!-- USER BASIC INFORMATION -->
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="2" child-class="pd-1" >
                        <column><i class="fa fa-user"></i> Celé jméno: </column>
                        <column>{{ $userdata["real_name"]}} {{ $userdata["surname"]}}</column>

                        <column><i class="fa fa-calendar-plus"></i> Datum registrace: </column>
                        <column>{{ real_date($userdata["registration_date"]) }}</column>

                        <column><i class="fa fa-calendar-check"></i> Poslední přihlášení: </column>
                        <column>{{ real_date($userdata["last_login"]) }}</column>

                        <column><i class="fa fa-envelope"></i> Email: </column>
                        <column>{{ $userdata["email"] }}</column>

                        <column><i class="fa fa-user-shield"></i> Admin: </column>
                        <column>@auth admin @ <i class="fa fa-check-circle t-success"></i>  @else <i class="fa fa-times t-error"></i> @endauth</column>

                    </row>
                </div>
            </div>
        </column>
        <column>
            <!-- USER CARD -->
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="auto">
                        <column>
                            <button class="button-circle width-40p height-40p button-info"><i class="fa fa-home"></i></button>
                        </column>
                    </row>
                    <div></div>
                </div>
            </div>
        </column>

        <column>
                
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="auto">
                        <column>
                            <button class="button-circle width-40p height-40p button-info"><i class="fa fa-plus-circle"></i></button>
                        </column>
                    </row>
                    <div></div>
                </div>
            </div>
        </column>

        <column>
                
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="auto">
                        <column>
                            <button class="button-circle width-40p height-40p button-info"><i class="fa fa-plus-circle"></i></button>
                        </column>
                    </row>
                    <div></div>
                </div>
            </div>
        </column>

        <column>
                
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="auto">
                        <column>
                            <button class="button-circle width-40p height-40p button-info"><i class="fa fa-plus-circle"></i></button>
                        </column>
                    </row>
                    <div></div>
                </div>
            </div>
        </column>

        <column>
                
            <div class="bgr-dark-2 pd-2" style="box-shadow: 4px 4px 5px black;">
                <div class="">
                    <row cols="auto">
                        <column>
                            <button class="button-circle width-40p height-40p button-info"><i class="fa fa-plus-circle"></i></button>
                        </column>
                    </row>
                    <div></div>
                </div>
            </div>
        </column>
    </row>
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