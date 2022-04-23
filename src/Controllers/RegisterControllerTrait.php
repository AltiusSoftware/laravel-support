<?php

namespace Altius\Controllers;

trait RegisterControllerTrait {


    static public function register() {
        $r = app()->make('router');

        

        $r->controller(get_called_class())->group(function () use($r) {
            static::routes($r);
        });
    }

    static protected function routes($r){

        !d('Error:  Overide static protected function routes in Controller');
        exit;
        return;

    }

}

