<?php namespace Altius\Forms;

class PasswordRemind extends \Altius\Services\Forms\Form {

    public function defineFields($fs) {

        $fs->email('email')
                ->valid('required');


    }
}
