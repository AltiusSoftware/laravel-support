<?php

namespace Altius\Services\Forms;
use Illuminate\Validation\Rule;

class Field {

    public $name;
    public $type;

    public      $valid=[];
    protected   $default=null;
    protected   $value=null;

    protected   $viewLevel=1;

    protected   $fields;
    public      $help=[];

    public function __construct($name,$type,$fields){
        $this->name=$name;
        $this->type=$type;
        $this->fields=$fields;
    }

    public function valid(...$rules) {
        foreach ($rules as $r) {
            if(is_string($r)) {    
                foreach(explode('|',$r) as $v)
                    $this->valid[]=$v;
            }
            else
                $this->valid[]=$r;
        }
        return $this;
    }

    public function unique($table=null) {
        $table??= $this->fields->object->getTable();
        $this->valid[] = Rule::unique($table,$this->name)->ignore($this->fields->object->id??1);
    }

    public function default($default) {
        $this->default=$default;
        return $this;

    }

    public function getformValue(){
        if(key_exists($this->name,request()->old()))
            return old($this->name);
        return $this->value;
    }

    public function getValue(){
        return $this->value;
    }

    public function setDefault() {
        $this->value = $this->default;

    }

    public function setValue($value){
        $this->value=$value;

    }

    public function fields() {
        return $this->fields;
    }


    public function display($value) {

        


        return $value;
    }

    public function getLabel() {
        return ucwords($this->name)   ;
    }

    public function getID() {
        return sprintf('f%d-%s',$this->fields::$id,$this->name);
    }

    public function isRequired() {
        return  in_array('required',$this->valid);
	}
}