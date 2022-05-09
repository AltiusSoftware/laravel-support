<?php namespace Altius\Forms;

class Login extends \Altius\Services\Forms\Form {

    
    


    public function defineFields($fs) {

        $fs->email('email')
                ->valid('required');

        $fs->password('password')
                ->valid('required');

        $fs->checkbox('remember');



    }
}
