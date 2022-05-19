<?php namespace Altius\Forms;

class FirstUserCreate extends \Altius\Services\Forms\Form {

    public function defineFields($fs) {

        $fs->text('name')
            ->valid('required','max:64');

        $fs->email('email')
                ->valid('required');

        $fs->password('password')
                ->valid('required', 'confirmed');

        $fs->password('password_confirmation');                

    }
}
