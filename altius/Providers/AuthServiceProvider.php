<?php

namespace Altius\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider {

    public function registerAppPolicy($appPolicyClass) {
        $reflect = new \ReflectionClass($appPolicyClass);
        foreach($reflect->getMethods(\ReflectionMethod::IS_PUBLIC) as $m) {
          if(!$m->isStatic()) {
            Gate::define(\Str::kebab($m->name),$appPolicyClass .'@'.$m->name);
            
          }
        }
    }
}