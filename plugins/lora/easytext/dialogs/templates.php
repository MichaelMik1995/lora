<?php
use App\Core\Application\Environment;
session_start();
$get_json_categories = file_get_contents("../../../../resources/plugins/easytext/templates/categories.json");

$categories = json_decode($get_json_categories, true, 4);

$get_config = parse_ini_file("../../../../config/web.ini");
$session_store = $get_config["WEB_SESSION_STORE_NAME"];

if(isset($_SESSION[$session_store]["uid"]))
{
    $user_uid = $_SESSION[$session_store]["uid"];
}


?>

<div class="easyText-Dialog_inner">
    <div class="content-center header-2 pdy-2">Vyberte šablonu:</div>
    <div class="content-center">* Kliknutím vyberete</div>
    <div class="es_block content-center">
        <?php foreach($categories["categories"] as $category) : ?>
            <div class="">
                <div class="header-5 t-bold"><?= $category ?></div>
                <?php 
                    $templates_json = file_get_contents("../../../../resources/plugins/easytext/templates/$user_uid/$category.json");
                    if($templates_json !== false) :
                        $temps = json_decode($templates_json, true, 4);
                    ?>
                        <div class="row-center cols-auto">
                            <?php foreach($temps as $temp) : ?>
                                <div class="column-shrink pd-1">
                                    <div class="bgr-dark pd-2">
                                        <?= $temp["title"] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php
                    endif;
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
