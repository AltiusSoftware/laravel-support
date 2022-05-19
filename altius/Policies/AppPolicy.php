<?php namespace Altius\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class AppPolicy {
    public function never(?User $user) {
        return Response::deny('This is never allowed');
    }
    
    public function always(?User $user) {
        return Response::allow('This is always allowed');
    }

    public function local(?User $user) {
        return app()->environment('local') ?
            Response::allow('This is allowed during local development'):
            Response::deny('This is only allowed during local development');
        ; 
    }

    public function altius(?User $user) {
        return app()->environment('local');
    }

    public function nousers(?User $user) {
        return User::count()==0;


    }
}
