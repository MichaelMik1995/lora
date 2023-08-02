<?php

$thumbnail = $_POST["image"];
$image = str_replace("/thumb","", $thumbnail);

function real_filesize($bytes, $decimals = 2) 
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

$filesize = filesize($image);

$parse_config = parse_ini_file("../../../../../config/web.ini");

echo json_encode(
        [
            "image" => $image, 
            "path" => str_replace("../../../../..", $parse_config["WEB_ADDRESS"], $image),
            "filesize" => real_filesize($filesize),
            "width" => getImageSize($image)[0],
            "height" => getImageSize($image)[1],
            "thumb_width" => getImageSize($thumbnail)[0],
            "thumb_height" => getImageSize($thumbnail)[1],
        ]
    );

