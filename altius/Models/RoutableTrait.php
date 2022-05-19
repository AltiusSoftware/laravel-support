<?php

namespace Altius\Models;

trait RoutableTrait {

    // These belong in a Translatable place


    public function getRouteSlug(){
        return $this->getTable();

    }

    
    public function view($name) {
        $views = [
            sprintf('models.%s.%s',$this->getTable(),$name),
            sprintf('altius::models.%s.%s',$this->getTable(),$name),
            sprintf('models._base.%s',$name),
            sprintf('altius::models._base.%s',$name)
        ];

        

        foreach($views as $v)
            if(view()->exists($v))
                return $v;
        

        view()->share('_missing',$views);

        return 'altius::dev.missing';


    }

    public function routeAll($name='index',...$params) {
        
        if($parent = $this->getParent()) {
            $params = [$parent->id] + $params;
            return route(sprintf('%s.%s.%s',$parent->getRouteSlug(),$this->getRouteSlug(),$name),...$params);
        }
        return route(sprintf('%s.%s',$this->getRouteSlug(),$name),...$params);
    }

    public function route($name='record',...$params) {
        $params = [$this->id] + $params;
        return route(sprintf('%s.%s',$this->getRouteSlug(),$name),...$params);
    }
// Chjild stuff

    // Parent Stuff
    public function defineParent(){
        return null;
    }


    public function getParent(){
        $rel = $this->defineParent();
        return $rel ? $this->$rel : null;
    }

    public function getChildrenInfo() { 
        $ret=[];

        foreach($this->defineChildren() as $rel) {
            $new =$this->$rel()->make(); 
            $ret[$rel] = (object)
                [
                    'rel'   => $rel,
                    'class' => $new::class,
                    'new'   =>   $new,
                ];
        }
        return $ret;
     }


    protected function defineChildren(){
        return[];
    }

}