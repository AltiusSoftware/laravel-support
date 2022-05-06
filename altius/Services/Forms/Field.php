<?php

namespace Altius\Services\Forms;
use Illuminate\Validation\Rule;

class Field {

    public $name;
    public $type;

    public      $valid=[];
    protected   $default=null;
    protected   $fields;
    public      $help=[];

    public function __construct($name,$type,$fields){
        $this->name=$name;
        $this->type=$type;
        $this->fields=$fields;
    }

    public function valid($valid) {
        if(is_string($valid)) {
            foreach(explode('|',$valid) as $v)
                $this->valid[]=$v;
        }
        else
            $this->valid[]=$valid;
        return $this;
    }

    public function unique($table=null) {
        $table??= $this->fields->object->getTable();
        $this->valid[] = Rule::unique($table,$this->name)->ignore($this->fields->object->id??1);
    }

    public function setDefault() {}//TBD

    public function fields() {
        return $this->fields;
    }



    public function getID() {
        return sprintf('f%d-%s',$this->fields::$id,$this->name);
    }

    public function isRequired() {
        return  in_array('required',$this->valid);
	}
}