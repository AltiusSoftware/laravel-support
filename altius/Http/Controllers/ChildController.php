<?php

namespace Altius\Http\Controllers;

class ChildController extends RecordController {

    protected function _routes($r){

        $this->_childRoutes($r);
        parent::_routes($r);
    }


    
    protected function setParent($parent){
        $record = new $this->model;
        $record->{$parent->getForeignKey()} = $parent->id;
        $this->setRecord($record);
    }
    

    protected function _childRoutes($r,$verbs=['create']) {

        $r->get("$this->parent/{{$this->parent}}/$this->slug",'index')
            ->name("$this->parent.record.$this->slug.index")
            ->title("models.$this->slug.plural")
            ->parent("$this->parent.record",fn($r)=>[$r]);




        foreach($verbs as $v)
            $this->_modelGet($r,$v)
                ->post();
    }

    protected function _modelGet($r,$verb){
        return
            $r->get("$this->parent/{{$this->parent}}/$this->slug/$verb",$verb)
                ->name("$this->parent.record.$this->slug.$verb")
                ->title("models.$verb")
                ->parent("$this->parent.record.$this->slug",fn($r)=>[$r]);
        

    }


    public function index($parent){

        $this->setParent($parent);
        $recs = $this->model::
            where($parent->getForeignKey(),'=',$parent->id)
                ->orderBy('id')->paginate(20);
        return view()->make( $this->record->view('index'),['records' => $recs]);
    }
    public function create() {
        $this->authorize('create',$this->model);
        $this->setRecord();

        $form = $this->record->getForm()
                ->ajax()
                ->setDefaults();
        return view()->make($this->record->view('create'),['form'=>$form]);
    }

    
    public function createPost() {
        $this->authorize('create',$this->model);
        $this->setRecord();
        $values = $this->record->getForm()
                    ->validate();

        $this->record
            ->fill($values)
            ->save();
        messages()->success('%s %s created',$this->record->plural,$this->record->summary);

        return redirect($this->record->route());
    }
}