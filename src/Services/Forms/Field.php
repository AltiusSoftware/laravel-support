<?php

namespace Altius\Services\Forms;

class Field {

    public $name;
    public $type;

    public $valid=null;
    protected $default=null;
    protected $fields;

    public function __construct($name,$type,$fields){
        $this->name=$name;
        $this->type=$type;
        $this->fields=$fields;
    }

    public function valid($valid) {
        $this->valid=$valid;
        return $this;
    }
    public function default($default) {
        $this->default=$default;
    }

    public function fields() {
        return $this->fields;
    }

    public function getID() {
        return $this->name;

    }


}