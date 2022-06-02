<?php

namespace Altius\Http\Controllers;

class ChildModelController extends BaseModelController {

    
    protected function _wrapModel() {
        \Route::prefix("$this->parentSlug/{{$this->parentSlug}}/$this->recordSlug")
        ->name("$this->parentSlug.$this->recordSlug.")
        ->group( function() {
            $this->_routesModel();
        });
    
    }

    protected function _routesModel() {
        \Route::get('','index')
            ->name('index')
            ->title("models.$this->recordSlug.plural")
            ->parent("$this->parentSlug.record",fn($r)=>[$r]);

        \Route::getPost('create','create')
            ->name('create')
            ->title('models.create')
            ->parent("$this->parentSlug.$this->recordSlug.index",fn($r)=>[$r]);
            
    }
    protected function _routesRecord(){
        \Route::get('','record')
                ->name('record')
                ->title(fn($r)=> $r->summary)
                ->parent("$this->parentSlug.$this->recordSlug.index",fn($r)=> [$r->getParent()])
                
                ;
        \Route::getPost("edit",'edit')
                ->name("edit")
                ->title('models.edit')
                ->parent("$this->recordSlug.record",fn($r)=>[$r]);


        \Route::getPost("delete",'delete')
                ->name("delete")
                ->title('models.delete')
                ->parent("$this->recordSlug.record",fn($r)=>[$r]);

            
    }



    public function index($parent){


        $recs = $this->record::
            where($parent->getForeignKey(),'=',$parent->id)
                ->orderBy('id')->paginate(20);

        return view()->make( $this->record->view('index'),['records' => $recs]);
    }
    public function create($parent) {
        $this->authorize('create',$this->record);

        $form = $this->record->getForm()
                ->ajax()
                ->setDefaults()
                ->setValues($this->record);

        return view()->make($this->record->view('create'),['form'=>$form]);
    }

    
    public function createPost($parent) {
        $this->authorize('create',$this->record);

        $values = $this->record->getForm()
                    ->validate();

        $this->record
            ->fill($values)
            ->save();

        messages()->success('%s %s created',$this->record->plural,$this->record->summary);

        return redirect($this->record->route());
    }
}