<?php

namespace Altius\Http\Controllers;

class ParentController extends RecordController {

    protected function _routes($r){

        $this->_parentRoutes($r);
        parent::_routes($r);
    }

    protected function _parentRoutes($r,$verbs=['create']) {

        $r->get($this->slug,'index')
            ->name("$this->slug.index")
            ->title("models.$this->slug.plural")
            ->parent('home');

        foreach($verbs as $v) 
            $this->_modelGet($r,$v)
                ->post();
    }
    protected function _modelGet($r,$verb){
        return
            $r->get("$this->slug/$verb",$verb)
                ->name("$this->slug.$verb")
                ->title("models.$verb")
                ->parent("$this->slug.index");

    }



    public function index(){

        $this->authorize('index',$this->model);
        $this->setRecord();

        $recs = $this->model::orderBy('id')->paginate(20);
        
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