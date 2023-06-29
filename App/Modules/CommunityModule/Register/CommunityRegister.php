<?php

use App\Modules\CommunityModule\Controller\CommunityController;
/**
 * Description of CommunityRegister
 *
 * @author miroka
 */
class CommunityRegister 
{
   public function register()
   {
        $class = CommunityController::class;

        return [
            [
                "url" => "community",
                "controller" => $class,
                "template" => "index",
                "route" => "community.index@default",
            ]
        ];
   }
}

