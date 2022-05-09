<?php

namespace Altius\Http\Controllers;


class LocalController extends BaseController {

    public function __construct() {
        $this->middleware('can:local');
    }

    protected function _routes($r){
        $r->get('/altius/local','index')
            ->name('altius.local.index');
    }
    public function index() {
        !d('altius.local');


    }
}