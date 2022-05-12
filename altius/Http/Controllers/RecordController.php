<?php

namespace Altius\Http\Controllers;



class RecordController extends BaseController {

    protected $model;
    protected $record;


    protected function setRecord($record=null){
        
        view()->share('record',
            $this->record = $record?: new($this->model)
        );

        if(app()->environment('local'))
        if($this->slug!=$this->record->getRouteSlug()) {
            !d('Route Slug and Controller slug should be the same',$this->slug, $this->record->getRouteSlug());
            exit;
        }

    }
    protected function _routes($r){
        $r->model($this->slug,$this->model);
        $this->_recordRoutes($r);
    }

    protected function _recordRoutes($r,$verbs=['edit','delete']){
        // not true if a child!
        $r->get("$this->slug/{{$this->slug}}",'record')
            ->name("$this->slug.record")
            ->title(fn($record) => $record->summary)
            ->parent("$this->slug.index");  
        

        foreach($verbs as $verb) {
            $this->_recordGet($r,$verb)
            ->post();
          }        
    }

    protected function _recordGet($r,$verb) {
        return
        $r->get("$this->slug/{{$this->slug}}/$verb",'record' . ucwords($verb))
            ->name("$this->slug.record.$verb")
            ->title("models.$verb")
            ->parent("$this->slug.record",fn($r)=>[$r]);


    }

    public function record($record) {
        $this->authorize('view',$record);
        $this->setRecord($record);
            
        return view()->make($record->view('record.index'));

    }
    public function recordEdit($record) {
        $this->authorize('edit',$record);
        $this->setRecord($record);

        
        $form = $this->record->getForm()
            ->ajax()
            ->setValues($this->record);

    

        return view()->make($this->record->view('edit'),['form'=>$form]);            

    }

    public function recordEditPost($record) {
        $this->authorize('edit',$record);
        
        $values = $record->getForm()
                    ->validate();
        $record->fill($values)
            ->save();
        
        messages()->info('%s %s has been updated',$record->singular, $record->summary);        

        return redirect($record->route());

    }

}