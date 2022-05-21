<?php

namespace Altius\Http\Middleware;


class ModelSetup {

    public function handle($request, \Closure $next)
    {
        $route = $request->route();
        $c = $route->getController();



        $p1 = reset($route->parameters);

        switch(true) {
            // RECORD!
            case (get_class($p1) == $c->class):
                $c->record=$p1;
                $c->parent=$p1->getParent();
                break;
            // Top Model
            case ($p1===false):         // no params.  This is a top level model request
                $c->record = new $c->class;
                $c->parent = null;//$c->record->parent;
                break;
            // Child Model
            default:
                $c->parent = $p1;
                $c->record= new $c->class;
                $c->record->{$c->parent->getForeignKey()} = $c->parent->id;
                break;


        }
       
        view()->share('record',$c->record);
        view()->share('parent',$c->parent);

        return $next($request);
    }

}