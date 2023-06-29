<div class="pd-2 bgr-dark-2 bd-round-2 bd-info bd-1">
    <form method="post" enctype="multipart/form-data" action="/games/app/game-insert">
        <!-- route("games.insert", [$model_class]) -->
        <input hidden type="text" name="token" value="7de5e25b384c4755cd4ec8748f72400909c2412c0eb15c0e39d71acf6bacbd45"> <input hidden type="text" name="SID" value="9ee29597694cd9189f9a5d73c0b7f516">

        <input hidden type='text' name='method' value='get'>

        <input hidden type='text' name='data' value='{{ http_query_builder($genres) }}'>
        <div class="form-line">
            <label for="title">Název hry</label><br>
            <input id="title" name="title" type="text" class="input-dark width-50 width-100-xsm pd-2" validation="required,maxchars128" placeholder="Aa...">

            <!-- Validation result for title -->
            <div valid-for="#title"></div>
        </div>

        <div class="row width-50 width-100-xsm">
            <div class="column-4 column-10-xsm">
                <label for="genres">Žánr</label><br>
                <select id="genres" name="genres" class="input-dark pd-2 bd-round-2 width-100 width-50-xsm">

                    <!-- Option genres loop -->
                    <?php foreach($genres as $genre) : ?>
                        <option value="<?php echo $genre['slug'] ?>"><?php echo $genre['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="column-6 column-xsm mgy-2-xsm">
                <label for="tags"># Tagy</label><br>
                <input id="tags" name="tags" type="text" class="input-dark width-100 pd-2" validation="maxchars256" placeholder="tag1,tag2...">

                <!-- Validation result for tags -->
                <div valid-for="#tags" class="pd-2"></div>
            </div>
        </div>

        <div class="row width-50 width-100-xsm">
            <div class="column-4 column-10-xsm">
                <label for="image">Obrázek</label><br>
                <input id="image" type="file" name="image" class="input-create t-dark width-90">
            </div>

            <div class="column-6 column-xsm mgy-2-xsm">
                <label for="src">Soubory hry (ZIP)</label><br>
                <input id="src" type="file" name="src" class="input-create t-dark width-90">
            </div>

            
        </div>

        <div class="mgy-2 form-line width-50 width-100-xsm">
            <label for="description">Popis hry</label><br>
            <?php echo $form ?>
        </div>
        

        <div class="form-line">
            <button type="submit" class="button button-info bd-round-2"><i class="fa fa-plus-circle"></i> Vytvořit</button>
        </div>

    </div>
    </form>
</div>