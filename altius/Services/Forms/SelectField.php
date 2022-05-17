<?php

namespace Altius\Services\Forms;
use Illuminate\Validation\Rule;

class SelectField extends Field {

    protected $options=[];

    public function options(array $options) {
        $this->options=$options;
        return $this;
    }
    public function combine() {
        $this->options = array_combine($this->options,$this->options);
        return $this;

    }
    
    public function getOptions() {
        return $this->options;
    }

    public function validSelection() {
        $this->valid[]=Rule::in( array_keys($this->options));
    
    }
}