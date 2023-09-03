<!-- Image + Description -->
<div class="content-center">
    <div class="t-big-2 header-2-xsm header-2-sm header-1-xsm t-italic pdy-2-xsm">Kreativně k dokonalosti</div>
    <div class="mg-auto-all pdy-2">
        <img rel="easySlider" src="{{ asset('img/avatar/me.png') }}" alt="profile-image" class="bd-round-circle">
    </div>
    <div class="t-bolder pdy-1-xsm">
        Miroslav Jirgl -> programátor webových stránek v PHP a basic designér;
    </div>
</div>

<div class="row row-reverse-xsm row-reverse-sm mgy-6 mgy-1-xsm">
    <div content-height-auto="main-dashboard-info" class="column-5 column-10-xsm column-10-sm column-center display-0-xsm display-0-sm pdx-5 mg-auto-all">
        <div>
            <img rel="easySlider" alt="profile-photo" src="{{ asset('img/logo/sov.png') }}" class="width-100-xsm" loading="lazy">
        </div>
    </div>

    <div content-height-auto="main-dashboard-info" class="column-5 column-10-xsm column-10-sm column-center pdx-5 mg-auto-all">
                <div class="eTcode width-80 width-100-xsm mgy-0 mgy-5-xsm mgy-5-sm height-100">
public function <span class='t-bold header-4 header-6-xsm header-6-sm'>yourselfInformation()</span>
{
    $my_name = "<span class='t-info'>Miroslav Jirgl</span>";
    $age = <span class='t-info'>{{ DATE('Y')-1995 }}</span>;
    $city = "<span class='t-info'>Praha - Sokolov</span>";
    
    $skills = [     <span class='t-success'>//Zkušenosti</span>
        "PHP" => "<span class='t-info'>OOP, MVC</span>",
        "JQuery" => "<span class='t-info'>Základy</span>",
        "MySQL" => "<span class='t-info'>Základy</span>",
        "HTML+CSS" => "<span class='t-info'>Základy</span>",
        "3D vývoj" => "<span class='t-info'>Blender</span>",
        "Herní vývoj" => "<span class='t-info'>Unity, UE</span>"
    ];

    $hobbies = [      <span class='t-success'>//Koníčky</span>
        "<span class='t-info'>Cyklistika</span>",
        "<span class='t-info'>Informatika</span>",
        "<span class='t-info'>PC Hardware</span>",
        "<span class='t-info'>Cvičení</span>",
        "<span class='t-info'>Turistika</span>",
        "<span class='t-info'>Gaučing</span>"
    ];
}
</div>
    </div>
</div>

<div class="mgy-2 pdy-2 bd-top-dark bgr-dark-2">
    <div class="row row-center-xsm row-center-sm row-center-sm row-center-md row-center-md row-center-lrg row-center-xlrg cols-auto col-space-3">
        <div class="column-shrink">
            <button redirect="portfolio" class="button-xlarge button-bd-info bd-round-symetric">Portfolio</button>
        </div>
        <div class="column-shrink">
            <button redirect="about/page/cv" class="button-xlarge button-bd-light bd-round-symetric">Curriculum vitae</button>
        </div>
    </div>
</div>

<div>
    <div class="header-3 header-4-xsm header-4-sm pdy-3 content-center">Nejnovější a nejlépe hodnocená portfolia</div>

@if !empty($items_by_rev) @
        <div class="row row-center-xsm row-center-sm row-center-sm row-center-md row-center-md row-center-lrg row-center-xlrg cols-5 cols-1-xsm cols-2-sm cols-3-md pdx-3-xsm pdx-2-sm">
            @foreach $items_by_rev as $item @
                @if $item["publish"] == 1 || ($item["publish"] == 0 && $item["author"] == "@useruid") @
                <div class="column-shrink pd-3 pd-1-xsm">
                    <div redirect="portfolio/item/{{ $item['url'] }}" id="portfolio-item-{{ $item['url'] }}" class="background-dark-2 bd-dark pd-1 bd-round-3 bd-1 anim-all-normal cursor-point">
                        <div content-height-auto="portfolio-title" class="content-center mg-auto-all header-4 pdy-1">
                            {{ $item["title"] }}
                        </div>
                        @if $item["publish"] == 0 @ 
                            <div class="subheader-3 t-warning content-center pdy-1"><i class="fa fa-close"></i> Nepublikováno</div> 
                        @else
                            <div class="subheader-3 t-success content-center pdy-1"><i class="fa fa-check-circle"></i> Publikováno {{ DATE("d.m.Y H:i", $item["updated_at"]) }}</div>
                        @endif
                        <div class="content-center">
                        @if file_exists("./App/Modules/PortfolioModule/public/img/category/".$item['category_url']."/image/thumb/main.png") @
                            @php $image = "./App/Modules/PortfolioModule/public/img/category/".$item['category_url']."/image/thumb/main.png" @
                        @else
                            @php $image = "./public/img/noimage.png" @
                        @endif

                            <img src="{{ $image }}" class="height-256p height-128p-xsm" loading="lazy">
                        </div>

                        <div class="pdy-2 content-center">
                                <i class="fa fa-star t-warning"></i> {{ $item["evaluation_average"] }}
                                <span class="mgx-1"></span>
                                <i class="fa fa-comments"></i> {{ $item["count_comments"] }}
                            </div>

                        <div content-height-auto="portfolio-desc" class="content-center pd-1">
                            <div>{{ $item["short_description"] }}</div>
                            
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
