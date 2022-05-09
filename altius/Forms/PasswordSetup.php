<?php namespace Altius\Forms;

use Illuminate\Validation\Rules\Password;

class PasswordSetup extends \Altius\Services\Forms\Form {

    public function defineFields($fs) {

        $fs->password('password')
                ->valid('required','confirmed',Password::min(8));

        $fs->password('password_confirmation');
    }
}
