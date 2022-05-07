<?php

namespace Altius\Controllers;


class AltiusController extends BaseController {

    public function __construct() {
        $this->middleware('can:altius');
    }

    static protected function routes($r){
        $r->get('/altius','index')
            ->name('altius.index');
    }
    public function index() {
        !d('Altius Remote Stuff!');


    }
}