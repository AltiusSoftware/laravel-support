<?php

namespace Altius\Controllers;


class LocalController extends BaseController {

    public function __construct() {
        $this->middleware('can:local');
    }

    static protected function routes($r){
        $r->get('/altius/local','index')
            ->name('altius.local.index');
    }
    public function index() {
        !d('altius.local');


    }
}