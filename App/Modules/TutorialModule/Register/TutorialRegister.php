<?php

use App\Modules\TutorialModule\Controller\TutorialController;
/**
 * Description of TutorialRegister
 *
 * @author miroka
 */
class TutorialRegister 
{
   public function register()
   {
        $class = TutorialController::class;

        return [
            [
                "url" => "tutorial",
                "controller" => $class,
                "route" => "tutorial.index@default",
                "template" => "index",
            ],
            [
                "url" => "tutorial/create",
                "controller" => $class,
                "route" => "tutorial.create@default",
                "template" => "create",
            ],
            [
                "url" => "tutorial/insert",
                "controller" => $class,
                "route" => "tutorial.insert@insert",
                "template" => "",
            ],
            [
                "url" => "tutorial/show/:param",
                "controller" => $class,
                "route" => "tutorial.show@get",
                "template" => "show",
            ],
            [
                "url" => "tutorial/edit/:param",
                "controller" => $class,
                "route" => "tutorial.edit@get",
                "template" => "edit",
            ],
            [
                "url" => "tutorial/update/:param",
                "controller" => $class,
                "route" => "tutorial.update@update",
                "template" => "",
            ],
            [
                "url" => "tutorial/delete/:param",
                "controller" => $class,
                "route" => "tutorial.delete@delete",
                "template" => "",
            ],
        ];
   }
}

