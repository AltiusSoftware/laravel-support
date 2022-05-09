<?php

namespace Altius\Http\Controllers;


class AltiusController extends BaseController {

    public function __construct() {
        $this->middleware('can:altius');
    }

    protected function _routes($r){
        $r->get('/altius','index')
            ->name('altius.index');

        $r->get('/altius/login','login')
            ->name('altius.login')
            ->post();

        }
    public function index() {
        !d('Altius Local Package');


        
    }
}