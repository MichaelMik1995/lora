<?php

use App\Modules\GamesModule\Controller\GamesController;
use App\Modules\GamesModule\Controller\Splitter\GamesBoardController;
use App\Modules\GamesModule\Controller\Splitter\GamesCrudController;

use App\Modules\GamesModule\Model\Games;

/**
 * Description of GamesRegister
 *
 * @author miroka
 */

class GamesRegister 
{
   public function register()
   {
        $class = GamesController::class;
        $board = GamesBoardController::class;
        $crud =  GamesCrudController::class;

        return [
            [
                "url" => "games",
                "controller" => $class,
                "template" => "home",
                "route" => "games.index@default",
            ],

            [
                "url" => "games/app/:page",
                "controller" => $class,
                "template" => "home",
                "route" => "games.app@get",
            ],
            

            [
                "url" => "games/app/:page/:param",
                "controller" => $class,
                "template" => "home",
                "route" => "games.app@get",
            ],
            [
                "url" => "games/visor/:page",
                "controller" => $class,
                "template" => "home",
                "route" => "games.visor@get",
            ],
            [
                "url" => "games/visor/:page/:param",
                "controller" => $class,
                "template" => "home",
                "route" => "games.visor@get",
            ],

        ];
   }
}

