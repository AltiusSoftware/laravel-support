<?php

namespace Altius\Http\Controllers;


abstract
class BaseModelController extends RegisterController {

    // Set
    public $class;

    // Routing
    protected $recordSlug;
    protected $parentSlug;
    
    // Executing
    protected $model;
    public $record;

    // override in 
    abstract protected function _routesRecord();
    abstract protected function _routesModel();

    public function _routes() {
        $this->_registerClass();
        $this->_wrapRecord();
        $this->_wrapModel();
    
    }

    protected function _wrapRecord() {

        \Route::prefix("$this->recordSlug/{{$this->recordSlug}}")
            ->name("$this->recordSlug.")
            ->group( function() {
                $this->_routesRecord();
            });

    }
    protected function _wrapModel() {
        if($this->parentSlug){
            \Route::prefix("$this->parentSlug/{{$this->parentSlug}}/$this->recordSlug")
            ->name("$this->parentSlug.$this->recordSlug.")
            ->group( function() {
                $this->_routesModel();
            });
        } else  {
            \Route::prefix("$this->recordSlug")
                ->name("$this->recordSlug.")
                ->group( function() {
                    $this->_routesModel();
                });
        }
    }

    protected function _registerClass() {
        if(is_null($this->class)) {
            !d('You must set the model $class in the controllers constructor ', get_class($this));
            exit;
        }

        $model = new $this->class;
        $this->recordSlug= $model->getRouteSlug();
        \Route::model($this->recordSlug,$this->class);

        $parent = $model->defineParent();

        if($parent) {
            $this->parentSlug = $model->$parent()->getRelated()->getRouteSlug();
        }


        return $model;



    }

}
