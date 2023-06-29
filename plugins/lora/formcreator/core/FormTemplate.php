<?php
declare (strict_types=1);

namespace plugins\Lora\formcreator\core;

use plugins\Lora\formcreator\src\FormCreator;

/**
 * Description of FormTemplate
 *
 * @author michaelmik
 */
class FormTemplate 
{
    protected $form_factory;
    
    public function __construct() 
    {
        $this->form_factory = new FormCreator();
    }
    
    public function formSignIn()
    {
        
    }
    
    public function formSignUp()
    {
        $class_input = " pd-2 bd-round-3 bd-bottom-create t-create t-bolder";
        
        return $this->form_factory
                ->form("/user/do-register", ["class"=>"m-3 background-dark-2 bd-create bd-round-3 pd-3"])
                ->formCell()
                    ->label("Your username/nick here: ", "name")->line()
                    ->input("text", ["required"=>"", "name"=>"name", "id"=>"name", "class"=>$class_input." f-input-75"])
                ->endFormCell()
                ->formCell()
                    ->label("Your email here: ", "email")->line()
                    ->input("email", ["required"=>"","name"=>"email", "id"=>"email", "class"=>$class_input." f-input-75"])
                ->endFormCell()
                ->formCell()
                    ->label("Your password here: ", "password1")->line()
                    ->input("password", ["required"=>"", "name"=>"password1", "id"=>"password1", "class"=>$class_input." f-input-50"])
                ->endFormCell()
                ->formCell()
                    ->label("Your password here again: ", "password2")->line()
                    ->input("password", ["required"=>"", "name"=>"password2", "id"=>"password2", "class"=>$class_input. " f-input-50"])
                ->endFormCell()
                ->formCell()
                    ->label("Write following year (4 chars): ", "antispam")->line()
                    ->input("text", ["required"=>"", "name"=>"antispam", "id"=>"antispam", "class"=>$class_input. " width-25"])
                ->endFormCell()
                ->submit("Register")
                ->endForm();
    }
}
