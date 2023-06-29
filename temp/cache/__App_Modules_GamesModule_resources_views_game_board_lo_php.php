
<?php if(!empty($games)) : ?>
<div class="pd-2">
    <div class="row cols-5">
        <?php foreach($games as $game) : ?>
            <div class="column-shrink pd-1">
                <div class="background-dark-2">

                    <!-- Game title -->
                    <div redirect="games/app/game-show/<?php echo $game['url'] ?>" class="pd-1 t-warning-2-hover">
                        <?php echo $game["name"] ?>
                    </div>

                    <!-- Game image PHP: If image exists->view ELSE get image from internet-->
                    <div class="">
                        <?php if(file_exists("./App/Modules/GamesModule/resources/games/".$game["url"]."/img/thumb/main.png")) : ?>
                            <img class="height-256p" src="./App/Modules/GamesModule/resources/games/<?php echo $game["url"] ?>/img/thumb/main.png">
                        <?php else : ?>
                            <img class="height-256p" src="https://media.istockphoto.com/id/1334436084/photo/top-down-view-of-colorful-illuminated-gaming-accessories-laying-on-table.jpg?s=612x612&w=0&k=20&c=E9xnbAZoBS5LlUX0q-zxT_3m6gEZpyB2k51_U4LLMNs=">
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div class="">
                        <?php echo $game["_description"] ?>
                    </div>

                    <!-- Evaluation | Play -->
                    <div class="row">
                        <div class="column-5">
                            <button class="button button-bd-success"><i class="fa fa-play"></i> Hrát</button>
                        </div>

                        <div class="column-5 content-right">
                            <?php echo $game["evaluation"] ?> <i class="fa fa-star t-warning"></i>
                        </div>
                    </div>
                </div>
            </div> 
        <?php endforeach; ?>
    </div>
</div>
<?php else : ?>
<div class="header-5">V této sekci není žádná hra</div>
<?php endif; ?>