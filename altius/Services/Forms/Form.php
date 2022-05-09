<?php

namespace Altius\Services\Forms;

class Form  {
    // Do we need to store object here?

    public $title=null;
	
    public $action=null;
	public $method="POST";
	public $ajax=false;
    public $cancel=null;

    protected $fields;
    protected $buttons;
	protected $values=[];
    protected $object=null;

    public function __construct() {
        $this->title=config('app.name');
        $this->buttons=collect();
        $this->fields = new Fields;
        $this->object($this);
    }

    // Fluent Setters.
    public function object($object,$group='') {
		$this->object=$object;
        $this->fields->object($object,$group);
		return $this;
	}
	public function title($title) {
		$this->title=$title;
		return $this;
	}

    public function action($url) {
		$this->action=$url;
		return $this;
	}
    public function ajax($v=true) {
		$this->ajax=$v;
		return $this;
	}
	public function cancel($url) {
		$this->cancel=$url;
		return $this;
	}

    public function fields() {
        return $this->fields;
    }
    
//Forms/Fields duality

    // Values Management
    public function setDefaults() {			// load defaults into form
        $this->fields->setDefaults();
		return $this;
	}

	public function setValues($values){        // sets values into form
        $this->fields->setValues($values);
		return $this;
	}

    public function validate($values=null) {			
        return $this->fields->validate($values);
    }

    // Stub implementation for forms.
    public function defineFields($fs) {
        
        // !d("Override DefineFields in Form Class");
        // exit;

    }

    
}
