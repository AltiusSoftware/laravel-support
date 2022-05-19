<?php namespace Altius\Test;

class Form extends \Altius\Services\Forms\Form {

    
    


    public function defineFields($fs) {

        $fs->id();


        $fs->text('textfield');



    }
}
