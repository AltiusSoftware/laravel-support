<?php

namespace Altius\Services\Forms;

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

}