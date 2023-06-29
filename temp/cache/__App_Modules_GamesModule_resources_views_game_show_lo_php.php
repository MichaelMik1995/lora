<div class="pd-2">
    <div class="row">
        <div class="column-4 column-10-xsm">
            <!-- Game image PHP: If image exists->view ELSE get image from internet-->
            <div class="content-center">
                <?php if(file_exists("./App/Modules/GamesModule/resources/games/".$game["url"]."/img/thumb/main.png")) : ?>
                    <img rel="easySlider" id="image" class="height-512p" src="./App/Modules/GamesModule/resources/games/<?php echo $game["url"] ?>/img/thumb/main.png">
                <?php else : ?>
                    <img rel="easySlider" id="image" class="height-512p" src="https://media.istockphoto.com/id/1334436084/photo/top-down-view-of-colorful-illuminated-gaming-accessories-laying-on-table.jpg?s=612x612&w=0&k=20&c=E9xnbAZoBS5LlUX0q-zxT_3m6gEZpyB2k51_U4LLMNs=">
                <?php endif; ?>
            </div>
            <div class="row cols-6">
                <?php foreach(glob("./App/Modules/GamesModule/resources/games/".$game["url"]."/img/thumb/*") as $image) : ?>
                    <div class="column-shrink pd-1">
                        <div onClick="$('#image').attr('src', '<?php echo $image ?>')" class="background-dark bd-dark-2 bd-2 bd-round-3 pd-1 content-center scale-12-hover anim-all-fast transparent-hover-40 cursor-point">
                            <img src="<?php echo $image ?>" class="height-64p">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="column-6 column-10-xsm">
            <div class="header-3 t-create content-center">
                <?php echo $game["name"] ?>
            </div>

            <div class="content-center pdy-2">
                <button class="button-large button-success bd-round-symetric"><i class="fa fa-play"></i> Spustit hru</button>
            </div>

            <div class="">
                Hodnocení: <?php echo $game["evaluation"] ?> <i class="fa fa-star t-warning"></i>
            </div>
        </div>
    </div>

    <div class="row pd-2">
        <div class="column-6 column-10-xsm">
            <div class="mgy-1">
                <?php foreach($game["array_tags"] as $tag) : ?>
                    <a class="button button-bd-cyan bd-round-3" href="/games/app/games-by-tag/<?php echo $tag ?>">#<?php echo $tag ?></a> 
                <?php endforeach; ?>
            </div>
            <div class="header-2 t-bold content-center">
                O hře: 
            </div>
            <div class="">
                <?php echo $game["_description"] ?>
            </div>
            
        </div>

        <div class="column-4 column-10-xsm">
        <div class="header-2 t-bold content-center">
                Hodnocení, diskuze: 
            </div>
        </div>
    </div>
</div>