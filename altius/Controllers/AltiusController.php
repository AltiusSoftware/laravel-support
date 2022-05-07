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
        !d(get_current_user());

        $file = base_path('vendor/altius/laravel-support');
        !d($file,is_link($file));
        
        symlink(base_path('../packages/altius/laravel-support'),base_path('vendor/altius/test'));
        
        !d(is_dir($file));

        $file = base_path('vendor/laravel/framework');
        !d($file,is_link($file));
        
        !d(is_dir($file));

        !d($file);
        !d('Altius Index');


    }
}