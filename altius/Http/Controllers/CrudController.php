<?php

namespace Altius\Http\Controllers;


class CrudController extends BaseController {

    protected $singular;
    protected $plural;
    protected $model;

    protected function _routes($r){
        $this->_crudRoutes($r);
    }

    public function __construct() {
        $this->setRecord(new ($this->model));
    }

    protected function setRecord($record){
        view()->share('record',$this->record=$record);
    }

    protected function _crudRoutes($r) {
        $model =sprintf('{%s}',$this->singular); 

        $r->model($this->singular,$this->model);
     
        $r->get("/{$this->plural}",'index')
            ->name("{$this->plural}.index")
            ->title("models.{$this->plural}.plural")
            ->parent('home');

        $r->get("/{$this->plural}/create",'create')
            ->name("{$this->plural}.create")
            ->title('models.create')
            ->parent("{$this->plural}.index")
            ->post();
     
        $r->get("/{$this->plural}/$model",'record')
            ->name("{$this->plural}.record")
            ->title(fn($record) => $record->summary)
            ->parent("{$this->plural}.index");  

        $verbs=[];
        $verbs = array_merge($verbs, ['edit','delete']);            

        foreach($verbs as $v) {
            $r->get("/{$this->plural}/$model/$v",'record' . ucwords($v))
              ->name("{$this->plural}.record.$v")
              ->title("models.$v")
              ->parent("{$this->plural}.record",fn($r)=>[$r])
              ->post();
          }        

    }


    public function index(){

        $this->authorize('index',$this->record);

        $recs = $this->model::orderBy('id')->paginate(20);
        
        return view()->make( $this->record->view('index'),['records' => $recs]);
    }


    public function create() {
        $this->authorize('create',$this->record);

        $form = $this->record->getForm()
                ->ajax()
                ->setDefaults();
        return view()->make($this->record->view('create'),['form'=>$form]);
    }

    public function createPost() {
        $this->authorize('create',$this->record);
        $values = $this->record->getForm()
                    ->validate();

        $this->record
            ->fill($values)
            ->save();
        messages()->success('%s %s created',$this->record->plural,$this->record->summary);

        return redirect($this->record->route());
    }
    public function record($record) {
        $this->authorize('view',$this->record);
        $this->setRecord($record);
            
        return view()->make($record->view('record'));

        !d($this->record);

    }

    public function recordEdit($record) {
        $this->authorize('edit',$this->record);
        $this->setRecord($record);

        !d($record->toArray());
        $form = $this->record->getForm()
        //->ajax()
        ->setValues($this->record->toArray());

        !d('Form Set Values not done');

        return view()->make($this->record->view('edit'),['form'=>$form]);            

    }
    public function recordEditPost($record) {
        $this->authorize('edit',$this->record);
        $values = $this->record->getForm()
                ->validate();

        !d($values);
        !d(request()->all());
        exit;

    }
    public function recordDelete($record) {
        $this->authorize('delete',$this->record);
    }
}