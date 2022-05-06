<?php

use Altius\Altius;

function messages($group='default') {
    static $inst=null;

    $inst ??= new \Altius\Services\Messages;

    $inst->group($group);

    return $inst;


	return $inst  ?? ( $inst = new \Altius\Services\Messages);
}

function altius() {
    return app(Altius::class);


}