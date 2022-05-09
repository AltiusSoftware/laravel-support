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

    // protected $slug==!

    public function view($name) {
        $m = sprintf('models.%s.%s',$this->slug,$name);
        $b = sprintf('models._base.%s',$name);
        return view()->exists($m) ? $m : $b;
    }

    public function routeAll($name='index',$params=[]) {
        return route(sprintf('%s.%s',$this->slug,$name),...$params);
    }

    public function route($name='record',$params=[]) {
        $params = [$this->id] + $params;
        return route(sprintf('%s.%s',$this->slug,$name),$params);
    }

}