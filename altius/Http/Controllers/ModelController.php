<?php

namespace Altius\Http\Controllers;



class ModelController extends BaseModelController {



    protected function _routesModel() {
        \Route::get('','index')
            ->name('index')
            ->title("models.$this->recordSlug.plural")
            ->parent('home');
        \Route::getPost('create','create')
            ->name('create')
            ->title('models.create')
            ->parent("$this->recordSlug.index");
    }
    protected function _routesRecord(){
        \Route::get('','record')
                ->name('record')
                ->title(fn($r)=> $r->summary)
                ->parent("$this->recordSlug.index");
        \Route::getPost("edit",'edit')
                ->name("edit")
                ->title('models.edit')
                ->parent("$this->recordSlug.record");
        \Route::getPost("delete",'delete')
                ->name("delete")
                ->title('models.delete')
                ->parent("$this->recordSlug.record");

            
    }

    public function index() {
        $this->authorize('index',$this->record);

        $records = $this->record
                ->secure()
                ->autoSort()
                ->paginate(20);

        return view()->make($this->record->view('index'),['records'=>$records]);
    }

    public function create() {
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