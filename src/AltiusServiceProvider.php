<?php

namespace Altius;

use Illuminate\Support\ServiceProvider;

use Altius\Services\Breadcrumbs;

class AltiusServiceProvider extends ServiceProvider
{
  public function register()
  {
    include(__DIR__ . '/helpers.php');
    $this->app->singleton(Breadcrumbs::class, function ($app) {
        return new Breadcrumbs;
    });

  }

  public function boot()
  {
    \Illuminate\Routing\Route::macro('title', function($title=null){
        app(Breadcrumbs::class)->title($this->getName(),$title);
        return $this;
    });
    \Illuminate\Routing\Route::macro('parent', function($parent=null,$params=null){
        app(Breadcrumbs::class)->parent($this->getName(),$parent,$params);
        return $this;
    });

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'altius');
  }
}