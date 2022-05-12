<?php

use Altius\Altius;

if(!function_exists('messages')) {

function messages($group='default') {
    static $inst=null;

    $inst ??= new \Altius\Services\Messages;

    $inst->group($group);

    return $inst;


	return $inst  ?? ( $inst = new \Altius\Services\Messages);
}
}

if(!function_exists('altius')) {
function altius() {
    return app(Altius::class);


}
}

if(!function_exists('tags')) {
    function tags(...$params) {

        return Gate::allows(...$params) ?
                'acl-allows'
            :   'acl-denies';

    }
}