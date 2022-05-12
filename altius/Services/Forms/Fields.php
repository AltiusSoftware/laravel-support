<?php

namespace Altius\Services\Forms;

use Illuminate\Support\Collection;

class Fields extends Collection {
    static public $id=3;

    protected $fieldTypes = [
        'text'      => Field::class,
        'email'      => Field::class,
        'password'  => Field::class,
        'checkbox'  => Field::class,
        'lookup'    => LookupField::class,
        'select'    => SelectField::class
    ];

    public $object=null;
    protected $group='';

    public function __call($method,$params) {

        if(isset($this->fieldTypes[$method])) {
            return $this[$params[0]] = new ($this->fieldTypes[$method])($params[0],$method,$this);
        }
        return parent::__call($method, $params);
    }

    public function object($object,$group='') {
        $this->object=$object;
        $this->group=$group;
        $this->buildFields();
        return $this;
    }

    protected function buildFields() {
        self::$id++;

        $method= 'defineFields'. ucwords($this->group);
        while($this->count())               // remove existing fields
            $this->pop();
        
        if(! method_exists($this->object,$method)) 
            throw new \Exception(sprintf('Method %s doesnt exist on %s', $method, get_class($this->object)));
        
        $this->object->$method($this);
        return $this;
        
    }

    // Forms Display Methods
    public function setDefaults() {			// load defaults into form
		foreach($this as $f) 
			$f->setDefault();
		return $this;
	}
	public function setValues($values){        // sets values into form




		foreach($this as $f) {
			$f->setValue(data_get($values,$f->name));				

		}
		return $this;
	}

    // Forms Processing Methods
    public function validate($values=null){
        $this->interceptValidation();
        $values ??= request()->all();
        return validator()->make($values,$this->getRules($values))->validate();
    }
    public function validateTest($values=null) {
        $values ??= request()->all();

        !d('Test Validate',get_class($this),$values);

        $v = validator()->make($values,$this->getRules($values));

        if($v->fails()) {
            !d('Failed');
            !d($v->errors());
        }
        else {
            !d('Valid!');
            !d($v->validated());
        }
    }
        
    protected function getRules($values) {
        $rules=[];
    
        foreach($this as $k => $f) {				// getRules from Fields.
            $rules[$k] = $f->valid ??'';
        }
        /*
        if($this->buttons->count()) {
            $rules['_submit'] = 'required|in:' . $this->buttons->pluck('name')->implode(',');
        }
        */
        // !d($rules);
        return $rules;
    }
    protected function interceptValidation() {
        // do lookups and other stuff here.
        return;

        if(request()->has('_modelLookup')) {
            $field = request('_modelLookup');
    
            $f = $this->fields[$field];
            if($f) {
                $f->lookup(request('q'));
            }
            abort(404);
        }
    }
       
        

}