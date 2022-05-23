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
    //protected $model;
    public $record;

    public function __construct() {
        $this->middleware(\Altius\Http\Middleware\ModelSetup::class);

    }

    // override in 




    protected function _routes() {
        $this->_registerClass();
        $this->_wrapModel();
        $this->_wrapRecord();

    
    }
    abstract protected function _routesModel();


    protected function _wrapRecord() {

        \Route::prefix("$this->recordSlug/{{$this->recordSlug}}")
            ->name("$this->recordSlug.")
            ->group( function() {
                $this->_routesRecord();
            });

    }
    protected function _wrapModel() {
        \Route::prefix("$this->recordSlug")
            ->name("$this->recordSlug.")
            ->group( function() {
                $this->_routesModel();
            });

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

    // Controller methods for Record Handling

    public function record($record) {
        $this->authorize('view',$record);
        return view()->make($record->view('record.view'));

    }
    public function edit($record) {
        $this->authorize('edit',$record);
        $form = $this->record->getForm()
            ->ajax()
            ->setValues($this->record);

        return view()->make($this->record->view('record.edit'),['form'=>$form]);            
    }

    public function editPost($record) {
        $this->authorize('edit',$record);
        
        $values = $record->getForm()
                    ->validate();
        $record->fill($values)
            ->save();
        
        messages()->info('%s %s has been updated',$record->singular, $record->summary);        
        return redirect($record->route());
    }

    public function delete($record){
        $this->authorize('delete',$record);

        !d($record->toArray());

    }


}
