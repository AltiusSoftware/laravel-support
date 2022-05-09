<?php

namespace Altius\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class BaseController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static public function register() {
        $r = app()->make('router');
        $r->controller(get_called_class())->group(function () use($r) {
            (new static) ->_routes($r);
        });
    }
    protected function _routes($r){
        !d('Error:  Overide static protected function routes in Controller');
        exit;
    }
}
