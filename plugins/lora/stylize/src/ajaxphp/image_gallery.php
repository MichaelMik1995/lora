<?php

$url = $_POST["path"];

$images = "";

$config = parse_ini_file("../../../../../config/web.ini");
$domain = $config["WEB_ADDRESS"];

foreach(glob("../../../../../$url/*") as $image)
{
    if(!is_dir($image))
    {
        $images .= "<div class='image-container column-shrink pd-1'>"
                . "<div class='content-center mg-auto'>
            <div class=''><img loading='lazy' style='max-height: 128px;' class='width-auto bd-round-3 image-thumbnail transparent-hover-50 cursor-point' alt='$image' src='$image'></div>"
        ."</div>"
                . "</div>";
    }
    
}

echo json_encode(['images' => $images, "url" => $url]);

?>