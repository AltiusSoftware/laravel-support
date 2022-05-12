<?php

namespace Altius\Models;

trait RoutableTrait {

    // These belong in a Translatable place
    public function getShortAttribute(){
        return $this->code ?: $this->name;

    }
    public function getSummaryAttribute(){
        return $this->name;
    }


    // function getChildren(), getParent()
    public function getRouteSlug(){
        return $this->getTable();

    }

    public function getParent(){ return null;}
    public function getChildren() { return []; }


    public function view($name) {
        $m = sprintf('models.%s.%s',$this->getTable(),$name);
        $b = sprintf('models._base.%s',$name);

        if(view()->exists($m))
            return $m;
        if(view()->exists($b))
            return $b;

        view()->share('_missing',[$b,$m]);

        return 'altius::dev.missing';


        return view()->exists($m) ? $m : 
                (view()->exists($b) ? $b : 
                'altius::dev.missing');
                
    }

    public function routeAll($name='index',...$params) {
        
        if($parent = $this->getParent()) {
            $params = [$parent->id] + $params;
            return route(sprintf('%s.record.%s.%s',$parent->getRouteSlug(),$this->getRouteSlug(),$name),...$params);
        }
        return route(sprintf('%s.%s',$this->getRouteSlug(),$name),...$params);
    }

    public function route($name='record',...$params) {
        $params = [$this->id] + $params;
        return route(sprintf('%s.%s',$this->getRouteSlug(),$name),...$params);
    }

}