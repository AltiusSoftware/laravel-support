<?php
namespace Altius\Services\Fields;

use Altius\Services\Forms\Form;

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
