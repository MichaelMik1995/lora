<?php
/*
    Plugin Discord generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\Discord;

class Discord
{
    public function send_notification($creator, $page, $message, $discord_hook = "dx")
    {
        $webhookurl = "";
        $base_url = "https://www.dxgamepro.cz/";
        switch($discord_hook)
        {            
            case "sov_news":
                $webhookurl = "https://discordapp.com/api/webhooks/873611626207666206/4C1iDeHrbXksNWtzHIgnUgp5q_X79M81YSJPGLo3cEiyAW4hA9DPRcvlv7NvC3a1UQTW";
                $title_content = "Novinka na Story of Vhallay! ";
                $user_name = "DXGamePRO Uživatel: ".$creator;
                $url = $base_url."sov/news";
                break;
            
            case "dxnews":
                $webhookurl = "https://discordapp.com/api/webhooks/997066106114154546/TTpmP7XP8zUpJF-yGOpLsUPY0-ll2mgwoue8I7Fy-k_cpjFvBYvdL8Ap8wN1DcpCI10Z";
                $title_content = "Novinka na webu! ";
                $user_name = "DXGamePRO Uživatel: ".$creator;
                $url = $base_url."dxgamepro";
                
                break;
        }
        

    //=======================================================================================================
    // Compose message. You can use Markdown
    // Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
    //========================================================================================================

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([
        // Message
        "content" => $title_content,

        // Username
        "username" => $user_name,

        // Avatar URL.
        // Uncoment to replace image set in webhook
        //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",

        // Text-to-speech
        "tts" => false,

        // File upload
        // "file" => "",

        // Embeds Array
        "embeds" => [
            [
                // Embed Title
                "title" => "Příspěvek v: ".$page."(Otevři kliknutím)",

                // Embed Type
                "type" => "rich",

                // Embed Description
                "description" => $message,

                // URL of title link
                "url" => $url,

                // Timestamp of embed must be formatted as ISO8601
                "timestamp" => $timestamp,

                // Embed left border color in HEX
                "color" => hexdec( "3366ff" ),

                // Footer
                "footer" => [
                    "text" => $base_url,
                    "icon_url" => ""
                ],

                // Image to send
                /*"image" => [
                    "url" => ""
                ],*/

                // Thumbnail
                //"thumbnail" => [
                //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
                //],

                // Author
                "author" => [
                    "name" => $creator,
                    "url" => "https://dxgamepro.cz"
                ],

                // Additional Fields array
                /*"fields" => [
                    // Field 1
                    [
                        "name" => "Field #1 Name",
                        "value" => "Field #1 Value",
                        "inline" => false
                    ],
                    // Field 2
                    [
                        "name" => "Field #2 Name",
                        "value" => "Field #2 Value",
                        "inline" => true
                    ]
                    // Etc..
                ]*/
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    curl_close( $ch );
    }
}
