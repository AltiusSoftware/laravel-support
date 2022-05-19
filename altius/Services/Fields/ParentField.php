<?php

namespace Altius\Services\Fields;

class ParentField extends Field {

    public $model;

    public function getRecord() {

        return $this->model::find($this->value);

        

    }
}