<?php

namespace Altius\Services;

class Breadcrumbs {


    protected $data=[];

    protected $view='altius::breadcrumbs.render';

    public function render($view=null) {
        $this->getBreadcrumbs();
        return view($view?:$this->view,['breadcrumbs' => collect($this->breadcrumbs)])->render();
    }

    public function getTitle(){
        $this->getBreadcrumbs();

        $end =$this->breadcrumbs
            ->where('name','!=','home')
            ->reverse()
            ->slice(0,3)
            ->pluck('title');

        $end->push(config('app.name'));

        return $end->implode(' - ');

        
    }

    protected $breadcrumbs=null;

    public function getBreadcrumbs() {
        if($this->breadcrumbs===null) {
            $this->breadcrumbs=collect();
            $r= \Route::getCurrentRoute();
            if(isset($this->data[$r->getName()])) 
                $this->resolve($r->getName(),$r->parameters());
        }
        return $this->breadcrumbs;
    }
    

    // settings mapped to routing.

    protected function set($name) {
        if(!isset($this->data[$name]))
            $this->data[$name] = new \stdClass;
        return $this->data[$name];
    }

    public function title($name,$title=null){
        $this->set($name)->title=$title?? ('routes.'.$name);
    }
    public function parent($name,$parent=null,$params=null){        // indicate parent=null for top of bc chain!
        $this->set($name)->parent=$parent;
        $this->set($name)->params=$params;
    }

    public function test() {
        $r= \Route::getCurrentRoute();

        $s=microtime(1);

        $this->resolve($r->getName(),$r->parameters());

        !d($this->breadcrumbs);
        !d(sprintf('Time: %1.6f s',microtime(1)-$s));

        
    }
    


    protected function resolve($name,$params){
        
        $url=  route($name,$params);
        $ret = (object)[
            'name'   => $name,
            'title'  => $this->resolveTitle($name,$params),
            'url'    => $url, 
            'current'=> $url== url()->full(),

        ];

        $this->breadcrumbs->prepend($ret);

        

        $parent = $this->data[$name]?->parent??null;

        if($parent) {
            $parentParamsFn = $this->data[$name]?->params??null;
            $parentParams = is_callable($parentParamsFn ) ?
                            $parentParamsFn(...array_values($params))
                            : $params;

            $this->resolve($parent,$parentParams);
        }
    
    }

    protected function resolveTitle($name,$params){
        $title= $this->data[$name]?->title??null;
        switch(true) {
            case is_null($title):
                return __('routes.' . $name);
            case is_string($title):
                return __($title);
            case is_callable($title):
                return $title(...array_values($params));
        }
        return 'Title Missing for route: ' . $name;
    }
    

}