<?php

namespace Altius\Http\Controllers;

class ChildModelController extends ModelController {

    protected function _routes($r){
        $r->model($this->slug,$this->model);

        $r  ->prefix("$this->slug/{{$this->slug}}")
            ->name("$this->slug.")
            ->group(function() use($r) {
                $this->_routesRecord($r);
            });

        $r  ->prefix("$this->parent/{{$this->parent}}/$this->slug")
            ->name("$this->parent.$this->slug.")
            ->group(function() use($r) {
                $this->_routesModel($r);
            });
    }
   
    
    protected function setParent($parent){
        $record = new $this->model;
        $record->{$parent->getForeignKey()} = $parent->id;
        $this->setRecord($record);
    }
    


    public function index($parent=null){

        $this->setParent($parent);
        $recs = $this->model::
            where($parent->getForeignKey(),'=',$parent->id)
                ->orderBy('id')->paginate(20);
        return view()->make( $this->record->view('index'),['records' => $recs]);
    }
    public function create($parent=null) {
        $this->authorize('create',$this->model);
        $this->setParent($parent);
        

        $form = $this->record->getForm()
                ->ajax()
                ->setDefaults();
        return view()->make($this->record->view('create'),['form'=>$form]);
    }

    
    public function createPost($parent=null) {
        $this->authorize('create',$this->model);
        $this->setParent($parent);

        $values = $this->record->getForm()
                    ->validate();

        $this->record
            ->fill($values)
            ->save();
        messages()->success('%s %s created',$this->record->plural,$this->record->summary);

        return redirect($this->record->route());
    }
}