<?php

namespace Altius\Models;

use Altius\Mail\PasswordReset;

// use Altius\Mail\PasswordSetup;

trait AuthenicatableTrait {



    public function getAppRoles() {
        return ['altius', 'admin','manager','worker'];

    }
    
    public function recordRoles() {
        return $this->hasMany(RecordRole::class);
    }
    
    public function sendPasswordReset($minutes) {
        $code = md5($this->email . $this->password);
        $url = url()->temporarySignedRoute('password.setup',now()->addMinutes($minutes),['code' => $code]);
        \Mail::to($this)->send( new PasswordReset($url, $minutes));
    }
}