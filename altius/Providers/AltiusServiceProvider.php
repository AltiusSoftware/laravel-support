<?php

namespace Altius\Providers;

use Illuminate\Support\ServiceProvider;

use Altius\Services\Breadcrumbs;
use Altius\Altius;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AltiusServiceProvider extends ServiceProvider
{
  public function register()
  {
    include(__DIR__ . '/../helpers.php');

    $this->app->singleton(Breadcrumbs::class, function ($app) {
        return new Breadcrumbs;
    });

    $this->app->singleton(Altius::class, function ($app) {
      return new Altius;
    });

  }

  public function boot()
  {
    // $this->commands();
    
    $this->routing();
    $this->policies();



    //$this->events();
    
    $this->loadViewsFrom( __DIR__.'/../../resources/views', 'altius');
  }


  protected function routing() {
        \Illuminate\Routing\Route::macro('title', function($title=null){
          app(Breadcrumbs::class)->title($this->getName(),$title);
          return $this;
      });
      \Illuminate\Routing\Route::macro('parent', function($parent=null,$params=null){
          app(Breadcrumbs::class)->parent($this->getName(),$parent,$params);
          return $this;
      });

      Route::middleware('web')
        ->group(__DIR__. '/../../routes/web.php');

      Route::pushMiddlewareToGroup('web',\Altius\Http\Middleware\Redirect::class);
  
  }
  protected function policies() {
    // \Altius\Policies\AppPolicy::register();
    // Register in 

  }
      
    
  
}