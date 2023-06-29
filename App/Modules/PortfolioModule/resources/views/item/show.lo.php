<div class="pdy-3">
    <div class="row cols-auto">
        <div class="column-shrink background-dark">
            <button redirect="portfolio" class="button button-dark"><i class="fa fa-home"></i> Hlavní <i
                    class="fa fa-chevron-right"></i></button>
        </div>
        <div class="column-shrink background-dark">
            <button redirect="portfolio/types/{{ $portfolio }}" class="button button-dark">{{ $portfolio_title }} <i
                    class="fa fa-chevron-right"></i></button>
        </div>
        <div class="column-shrink background-dark">
            <button redirect="portfolio/category/{{ $category }}" class="button button-dark">{{ $category_title }} <i
                    class="fa fa-chevron-right"></i></button>
        </div>
    </div>
</div>

<div class="content-center header-2 t-bold pdy-2">
    {{ $item["title"] }}
</div>

<!-- Admin -->
@auth admin @
<div class="content-right pdy-2">
    <button redirect="portfolio/item-edit/{{ $item['url'] }}" class="button button-dark bd-round-symetric"><i
            class="fa fa-edit"></i> Upravit</button>
    <button onClick="GUIDialog.dialogConfirm('Opravdu chcete smazat příspěvek?', () => {$('#item-delete').submit()})" class="button button-dark bd-round-symetric"><i class="fa fa-trash"></i> Smazat</button>
</div>

<form id="item-delete" method="post" action="/portfolio/item-delete" class="display-0">
    @csrfgen
    @request(delete)

    <input type="text" name="item" value="{{ $item['url'] }}">
    <input type="text" name="category" value="{{ $category }}">
    <input type="submit">
</form>
@endauth

<hr>
<div class="content-center t-italic header-6-lrg">{{ $item["short_description"] }}</div>

<div class="">
    <div class="row-center">
    @foreach glob("./App/Modules/PortfolioModule/public/img/item/".$item['url']."/image/thumb/*") as
                    $image @
        <div class="column-shrink pd-2">
            <img rel="easySlider" src="{{ $image }}" class="bd-round-3 height-128p height-64p-xsm">
        </div>
    @endforeach
    </div>
</div>

@if $item["web_url"] != "" @
<div class="content-center-xsm">
    <a href="{{ $item['web_url'] }}" target="_blank" class="t-dxgamepro t-bold t-info-hover"><i class="fa fa-globe"></i> {{ $item["web_url"] }}</a>
</div>
@endif

<div class="pdy-4">
    {{ $item['_content'] }}
</div>

<div class="row bd-top-dark bd-4">

    <div class="column-3 column-10-xsm column-5-sm">
        <!-- REWIEWS -->
        <div class="header-3 t-info pd-1">Recenze: {{ count($reviews) }} </div>
        @if !empty($reviews) @
        @foreach $reviews as $review @
        <div class=' background-dark-2 bd-left-dark pd-2 mgy-2 mgx-1'>
            <div class='content-center-xsm pd-2 header-6'>
                <div class='row'>
                    <div class='column column-10-xsm'>
                        @php $rounded = $review["evaluation"] @

                        @if $rounded >= 5 @
                        <i class="fa fa-star t-info"></i>
                        <i class="fa fa-star t-info"></i>
                        <i class="fa fa-star t-info"></i>
                        <i class="fa fa-star t-info"></i>
                        <i class="fa fa-star t-info"></i>

                        @elseif ($rounded == 0) @
                        <i class="fa fa-star t-light"></i> (0)
                        @else
                        @php for($i=0; $i<$rounded; $i++) : @ <i class="fa fa-star t-warning"></i>
                            @php endfor; @
                            @endif
                    </div>
                    <div class='column column-10-xsm content-right content-center-xsm'>
                        <span class="t-info t-bolder">

                            @if $review["author"] == "" @
                            Bez jména
                            @else
                            {{$review["author"]}}
                            @endif
                        </span>

                        {{DATE("d.m.Y H:i:s", $review['updated_at'])}}
                    </div>
                </div>
            </div>
            <div class='pd-2 mgy-2'>
                {{$review['content']}}
            </div>

            <div class="header-6 t-info pdx-2 pdy-1">
                <i class='fa fa-check'></i>
                @if empty($review['positives']) @
                NIC
                @else
                {{$review['positives']}}
                @endif
            </div>

            <div class="header-6 t-error pdx-2 pdy-1">
                <i class='fa fa-close'></i>
                @if empty($review['negatives']) @
                NIC
                @else
                {{$review['negatives']}}
                @endif
            </div>
        </div>
        @endforeach
        @else
        <div class="content-center header-4 t-info pdy-2">Prozatím nikdo nehodnotil</div>
        @endif
    </div>

    <div id="reviews" class="column-4 column-10-xsm column-5-sm pd-2 pd-0-xsm bgr-dark-2">

        <!-- Write Review -->
        <div id="under-content-header" class="content-center header-3 pdy-2 t-info">
            <i class="fa fa-star"></i> Napsat recenzi
        </div>

        <div class="">
            <form method="post" action="/portfolio/item-review-insert">
                @csrfgen
                @request(insert)
                <input hidden type="text" name="item-id" value="{{ $item['url'] }}">

                <!-- User name -->
                <div class="form-line">
                    <label for="author-name" class="form-label">Jméno (nepovinné)</label><br>
                    <input id="author-name" name="author-name" type="text"
                        class="input-dark pd-2 width-50 width-100-xsm width-100-sm" validation="maxchars64">
                        <div class="pd-1" valid-for="#author-name"></div>
                </div>

                <!-- Evaluation -->
                <div class="form-line content-center-xsm">
                    <label class="form-label">Hodnocení</label><br>
                    <div id="eval-stars" onMouseOut="resetRating();" class="form-line">
                        <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();" onClick="addRating(this);"
                            id="eval-star" class="fa fa-star cursor-point eval-star header-6"></i>
                        <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();" onClick="addRating(this);"
                            copy-attr="eval-star:class"></i>
                        <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();" onClick="addRating(this);"
                            copy-attr="eval-star:class"></i>
                        <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();" onClick="addRating(this);"
                            copy-attr="eval-star:class"></i>
                        <i onmouseover="highlightStar(this);" onmouseout="removeHighlight();" onClick="addRating(this);"
                            copy-attr="eval-star:class"></i>

                        <span id="rating-eval" class="header-6 mgx-2">0</span>
                        <input hidden id="rating" type="number" min="0" max="5" name="rating-evaluation" value="0">
                    </div>
                </div>

                <div class="form-line">
                    <div class="row">
                        <div class="column-5 pd-1">
                            <label for="positives" class="t-info"><i class="fa fa-check"></i> Klady</label><br>
                            <textarea id="positives" name="cnt-positives" placeholder="Aa..."
                                class="input-dark pd-2 height-128p v-resy width-100" validation="maxchars1024"></textarea>
                                <div class="pd-1" valid-for="#positives"></div>
                        </div>
                        <div class="column-5 pd-1">
                            <label for="negatives" class="t-error"><i class="fa fa-close"></i> Zápory</label><br>
                            <textarea id="negatives" name="cnt-negatives" placeholder="Aa..."
                                class="input-dark pd-2 height-128p v-resy width-100" validation="maxchars1024"></textarea>
                                <div class="pd-1" valid-for="#negatives"></div>
                        </div>
                    </div>
                    <div class="pd-1">
                        <label for="review-content" class=""><i class="fa fa-pen"></i> Obsah</label><br>
                        <textarea required id="rev-content" name="cnt-review" placeholder="Aa..."
                            class="input-dark pd-2 height-128p v-resy width-100" validation="required,maxchars4096"></textarea>
                            <div class="pd-1" valid-for="#rev-content"></div>
                        <div class="t-italic">* Před odesláním recenze si vše překontrolujte. Recenzi již nebude možné
                            upravit</div>
                    </div>
                </div>

                <div class="form-line pd-1">
                    <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-star"></i> Vložit
                        recenzi</button>
                </div>
            </form>
        </div>

        <hr>
        <!-- Write Comment -->
        <div copy-attr="under-content-header:class">
            <i class="fa fa-comments"></i> Napsat komentář
        </div>

        <div class="">
            <form method="post" action="/portfolio/item-comment-insert">
                @csrfgen
                @request(insert)
                <input hidden name='item-url' value="{{$item['url']}}">
                <div class="form-line">
                    <div class="form-label"><label for="comment-header">Název: </label></div>
                    <input id="comment-header" validation="required,maxchars64" name="comment-header"
                        class="input-dark width-50 width-100-xsm width-100-sm pd-1">
                    <div valid-for="#comment-header" class="pd-1"></div>
                </div>

                @ifguest
                <div class="form-line">
                    <div class="row">
                        <div class="column-4">
                            <div class="form-label"><label for="comment-author">Jméno: </label></div>
                            <input id="comment-author" validation="max-chars64" name="comment-author"
                                class="input-dark width-90 pd-1">
                            <div valid-for="#comment-author" class="pd-1"></div>
                        </div>
                        <div class="column-6">
                            <div class="form-label"><label for="comment-author">Email: </label></div>
                            <input id="comment-email" validation="maxchars128" name="comment-email"
                                class="input-dark width-100 pd-1">
                            <div valid-for="#comment-email" class="pd-1"></div>
                        </div>
                    </div>
                </div>
                @else
                <input hidden id="comment-author" name="comment-author" value="@useruid">
                <input hidden id="comment-email" name="comment-email" value="dxgamepro@email.cz">
                @endif

                <div class="form-line">
                    <div class="form-label"><label for="comment-text">Obsah: </label></div>
                    <textarea style="min-height: 10em;" validation="required,maxchars2048" class="input-dark width-100"
                        id="comment-text" name="comment-text"></textarea>
                    <div class="t-italic">* Před odesláním formuláře si vše překontrolujte. Komentář již nebude možné
                        upravit</div>
                    <div valid-for="#comment-text" class="pd-1"></div>

                </div>

                <div class="row form-line cursor-point">
                    <div class='column column-10-xsm content-center-xsm'>
                        <button class='button button-info bd-round-symetric'><i class="fa fa-comment"></i>
                            Komentovat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="column-3 column-10-xsm column-10-sm">
        <!-- COMMENTS -->
        <div class="header-3 t-info pd-1">Komentáře: {{ count($comments) }} </div>
        @if !empty($comments) @
        @foreach $comments as $comment @
        <div class=' background-dark-2 bd-right-dark pd-2 mgy-2 mgx-1'>

            <!-- COMMENT BLock -->
                <div class='pdx-1 t-bolder t-{{$color}}'>
                    <div class=" pd-2 bd-round-3">
                        <div class="pdy-1">
                            <div class="content-center header-6">{{ $comment["title"] }}</div>
                            <div class="t-info">
                                <i class='fa fa-comment'></i>
                                <span class="header-6">{{$comment['author']}}</span>
                                @if $comment["email"] == "" @
                                    (bezemailu)
                                @else
                                    ({{ $comment["email"] }})
                                @endif
                                
                                 | <small>{{DATE('d.m.Y H:i', $comment['updated_at'])}}</small>
                            </div>
                        </div>
                        <div class="pd-1">
                            {{$comment['content']}}
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Comment answer -->
                <div class="pd-1 bd-round-2">

                    <!-- FORM -->
                    <div class="">
                        <form method="post" action="portfolio/item-answer-insert">
                            @csrfgen
                            @request(insert)
                            <input hidden type="text" name="item" value="{{ $item['url'] }}">
                            <input hidden type="text" name="comment" value="{{ $comment['url'] }}">
                            <details>
                                <summary>Odpovědět: </summary>

                                @ifguest
                                <div class="form-line">
                                    <label for="answer-author">Jméno: </label><br>
                                    <input type="text" id="answer-author-{{ $comment['url'] }}" name="answer-author" class="input-dark pd-2 width-50 width-100-xsm" validation="maxchars128">
                                    <div class="pd-1" valid-for="#answer-author-{{ $comment['url'] }}"></div>
                                </div>
                                @else
                                <input hidden name="answer-author" value="@username">
                                @endif

                                <div class="form-line">
                                    <label for="answer-content">Obsah: </label><br>
                                    <textarea id="answer-content-{{ $comment['url'] }}" name="answer-content" 
                                        validation="required,maxchars4096"
                                        class="width-100 height-128p v-resy input-dark" 
                                        placeholder="Odpovědět k: {{ $comment['title'] }}"></textarea>
                                    <div class="pd-1" valid-for="#answer-content-{{ $comment['url'] }}"></div>
                                </div>

                                <div class="form-line content-right">
                                    <button type="submit" class="button button-info bd-round-symetric"><i class="fa fa-comment"></i> Odpovědět</button>
                                </div>
                            </details>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="column-1"></div>
                    <div class="column-9">
                        @if !empty($comment["answers"]) @
                            @foreach $comment["answers"] as $answer @
                                <div class="mgy-2 bgr-dark-3 pd-2">
                                    <div class="">{{ $answer["author"] }} | {{ DATE("d.m.Y H:i:s", $answer["updated_at"]) }}</div>
                                    <div class="pd-2">
                                        {{ $answer["content"] }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        @endforeach
        @else
        <div class="content-center header-4 t-info pdy-2">Prozatím nikdo nekomentoval</div>
        @endif
    </div>
</div>

<script>

    function highlightStar(obj) {
        removeHighlight();
        $('#eval-stars i').each(function (index) {
            $(this).addClass('t-warning');
            if (index == $("#eval-stars i").index(obj)) {
                return false;
            }
        });
    }

    function removeHighlight() {
        $('#eval-stars i').removeClass('t-warning');
    }

    function addRating(obj) {
        $('#eval-stars i').each(function (index) {

            $(this).addClass('t-warning');
            $('#rating').val((index + 1));
            if (index == $("#eval-stars i").index(obj)) {
                $('#rating-eval').text(index + 1);
                return false;
            }
        });
    }

    function resetRating() {
        if ($("#rating").val()) {
            $('#eval-stars i').each(function (index) {
                $(this).addClass('t-warning');
                if ((index + 1) == $("#rating").val()) {
                    return false;
                }
            });
        }
    }

</script>