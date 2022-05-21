<?php

namespace Altius\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class RegisterController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    static public function register() {

        \Route::controller(get_called_class())->group(function () {
            (new static)->_routes();
     
            
        });
    }
    protected function _routes(){
        !d('Error:  Overide static protected function routes in Controller');
        exit;
    }
}
