<?php

namespace Altius\Services\Forms;

class LookupField extends BaseField {

    protected $model;
    public function model($model) {
        $this->model=$model;


    }
}