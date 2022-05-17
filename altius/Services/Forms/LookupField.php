<?php

namespace Altius\Services\Forms;

class LookupField extends Field {

    protected $model;
    public function model($model) {
        $this->model=$model;


    }
}