<?php

namespace Altius\Http\Controllers;



class ModelController extends BaseRecordController {




    public function index() {
        $this->setRecord();
        $this->authorize('index',$this->record);

        $records = $this->model::orderBy('id')->paginate(20);

        

        return view()->make($this->record->view('index'),['records'=>$records]);
    }

    public function create() {
        $this->setRecord();
        $this->authorize('create',$this->record);
        $form = $this->record->getForm()
            //->ajax()
            ->setDefaults();
        
            return view()->make($this->record->view('create'),['form'=>$form]);            
    }
    public function createPost() {
        $record= $this->setRecord();
        $this->authorize('create',$record);
        
        $values = $record->getForm()
                    ->validate();

        $record->fill($values)
            ->save();
        
        messages()->info('%s %s has been created',$record->singular, $record->summary);        
        return redirect($record->route());
    }




}