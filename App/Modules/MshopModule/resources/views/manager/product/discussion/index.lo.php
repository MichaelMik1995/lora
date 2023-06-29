<div class="pd-2">
    <div class="header-5 pdy-2">
        Nejnovější dotazy k příspěvkům:
    </div>
    
    <div class="row cols-5 cols-1-xsm cols-2-sm cols-3-md cols-6-xlrg">
    @foreach $all as $row @
    <div class="column-shrink">
        <div class=" pd-1">
            <div class="background-dark-3 bd-round-3 bd-dark">
                <!-- product IMAGE -->
                <div class="content-center pdy-2">
                    <img redirect="mshop/manager/manager-product-show/{{$row['url']}}" class="image-h-auto" src="{{$this->modasset("mshop", "img/product/".$row["url"]."/thumb/main.png")}}">
                </div>

                <div class="t-italic content-center">

                    <!-- DATE -->
                    <div class="pdy-1">
                        {{DATE("d.m.Y H:i:s", $row["created_at"])}}
                    </div>

                    <!-- CONTENT -->
                    <div content-height-auto="cnt-auto" class="content-center t-custom-1 mg-auto-all">
                        {{$row["content"]}}
                    </div>

                    <!-- Send answer FORM -->
                    <div class='mgy-2 content-center'>
                        <form id="form-send-{{$row['id']}}" method='post' action='/mshop/manager/disscussion-add-comment/{{$row['id']}}'>
                            @csrfgen
                            <div class='pdy-1'>
                                <textarea required validation="required,maxchars2048" placeholder="Rychlá odpověď ..." name='content' id='content-{{$row['id']}}' class="height-64p v-resy width-90 background-none bd-custom-2 pd-1 t-custom-1 bd-round-2"></textarea>
                            </div>
                            <input hidden type="submit">
                        </form>

                        <!-- Send & View Button -->
                        <div class="row">
                            <div class="column pdx-2">
                                <button onClick="$('#form-send-{{$row['id']}}').submit()" class="button button-custom-main-2"><i class="fa fa-comment"></i></button>
                            </div>

                            <div class="column content-right pdx-8">
                                <button redirect="mshop/manager/manager-product-show/{{$row['url']}}" class="button button-custom-main-1"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>

                        <div class="content-center pdy-1" valid-for="#content-{{$row['id']}}">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>