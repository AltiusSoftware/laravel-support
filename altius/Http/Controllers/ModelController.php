<?php

namespace Altius\Http\Controllers;



class ModelController extends BaseController {

    protected $model;
    protected $slug;
    protected $record;


    protected function _routes($r){
        $r->model($this->slug,$this->model);


        $r  ->prefix($this->slug)
            ->name("$this->slug.")
            ->group(function() use($r) {
                $this->_routesModel($r);
            });
        $r  ->prefix("$this->slug/{{$this->slug}}")
            ->name("$this->slug.")
            ->group(function() use($r) {
                $this->_routesRecord($r);
        });

    }

    protected function _routesRecord($r) {


        $route = 
        $r->get("",'record')
            ->name("record")
            ->title(fn($r)=>$r->summary);
        
        if(isset($this->parent))
            $route->parent("$this->parent.$this->slug.index", fn($r)=> [$r->getParent()]);
        else
            $route->parent("$this->slug.index");

        $r->getPost("edit",'edit')
            ->name("edit")
            ->title('models.edit')
            ->parent("$this->slug.record", fn($r)=>[$r]);

        $r->getPost("delete",'delete')
            ->name("delete")
            ->title('models.delete')
            ->parent("$this->slug.record", fn($r)=>[$r]);
            
    }

    protected function _routesModel($r) {
        $route = 
        $r->get('','index')
            ->name('index')
            ->title("models.$this->slug.plural");
        
        if(isset($this->parent))
            $route->parent("$this->parent.record",  fn($r)=> [$r]);
        else
            $route->parent('home');

        $route = 
        $r->getPost('create','create')
            ->name('create')
            ->title('models.create');

        if(isset($this->parent))
            $route->parent("$this->parent.$this->slug.index",  fn($r)=> [$r]);
        else
            $route->parent("$this->slug.index");


            
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

    public function index($record=null) {
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