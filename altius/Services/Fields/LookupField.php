<?php

namespace Altius\Services\Fields;

class LookupField extends Field {

    protected $model;
    public function model($model) {
        $this->model=$model;
        
        $this->valid[]=sprintf('exists:%s,id',$model);

        return $this;

    }

    public function getOptions() {
        $ret = $this->model::get()->pluck('summary','id')->sort();

        return $ret;


    }
    public function getRecord() {

        return $this->model::find($this->value);

        

    }
}