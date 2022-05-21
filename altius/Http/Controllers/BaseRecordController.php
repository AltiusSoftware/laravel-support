<?php

namespace Altius\Http\Controllers;


abstract
class BaseRecordController extends BaseModelController {


    public function __construct() {
        $this->middleware(\Altius\Http\Middleware\ModelSetup::class);

    }
    protected function _routesModel() {
        \Route::get('','index')
            ->name('index');
        \Route::getPost('create','create')
            ->name('create')
            ->title('models.create');
    }
    
    protected function _routesRecord(){
        
        \Route::get('','record')
                ->name('record');
        \Route::getPost("edit",'edit')
                ->name("edit")
                ->title('models.edit')
                ->parent("$this->recordSlug.record", fn($r)=>[$r]);
        \Route::getPost("delete",'delete')
                ->name("delete")
                ->title('models.delete')
                ->parent("$this->recordSlug.record", fn($r)=>[$r]);

            
    }

    protected function _setup(){
        // What could this be
        // Record
        $route = \Route::current();
        

        

        
        
        $first = reset($route->parameters);

        !d($first);


        if($first) {
            !d(get_class($first));
            !d($first->toArray());
            exit;

        } else {
            $record = new $this->class;
        }
        view()->share('record',
            $this->record = $record
            );

        !d(get_class($record),$record->toArray());

        !d($this->class);

        !d($route->params);
        exit;
    }


    protected function setRecord($record=null){
        
        view()->share('record',
            $this->record = $record?: new($this->model)
        );

        if(app()->environment('local'))
        if($this->slug!=$this->record->getRouteSlug()) {
            !d('Route Slug and Controller slug should be the same',$this->slug, $this->record->getRouteSlug());
            exit;
        }
        return $this->record;
    }


    public function record($record) {
        $this->authorize('view',$record);
        $this->setRecord($record);
            
        return view()->make($record->view('record.view'));

    }
    public function edit($record) {
        $this->authorize('edit',$record);
        $this->setRecord($record);
        
        $form = $this->record->getForm()
          //  ->ajax()
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