<?php


function messages($group='default') {
    static $inst=null;

    $inst ??= new \Altius\Services\Messages;

    $inst->group($group);

    return $inst;


	return $inst  ?? ( $inst = new \Altius\Services\Messages);
}