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
                ->parent("$this->recordSlug.record",fn($r)=>[$r]);
        \Route::getPost("delete",'delete')
                ->name("delete")
                ->title('models.delete')
                ->parent("$this->recordSlug.record",fn($r)=>[$r]);

            
    }

    public function index() {
        $this->authorize('index',$this->record);

        $rows = in_array(request()->get('rows'),[20,50,100]) ? request()->get('rows') : 20;

        

        $records = $this->record
                ->secure()
                ->autoSort()
                ->autoSearch()
                ->paginate($rows);

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

        $this->authorize('create',$this->record);
        
        $values = $this->record->getForm()
                    ->validate();

        $this->record->fill($values)
            ->save();
        
        messages()->info('%s %s has been created',$this->record->singular, $this->record->summary);        
        return redirect($this->record->route());
    }




}