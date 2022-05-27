<?php

namespace Altius\Services\Fields;

class DateField extends Field {

    public $carbon=null;
    public function getValue() {
        return $this->value?->format('Y-m-d');
    }

    public function __setValue($v) {

        switch(true){
            case is_string($v):
                $this->value=$v;
                break;
            case is_object($v) && is_a($v,Carbon::class):
                $this->value=$v->format('Y-m-d');
                break;


        }


    }

}