<?php
namespace Altius\Services\Forms;

trait HasFieldsTrait {

    public function getFields($group=''){
        return (new Fields())
                ->object($this,$group);
    }
    public function getForm($group='') {
        return (new Form())
                ->object($this,$group);
    }
}
