<?php

namespace Altius\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Altius\Services\Breadcrumbs;
use Altius\Altius;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
//use Illuminate\Routing\Router;

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
    $this->bootCommands();
    
    $this->bootRouting();

    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');


    Blade::directive('tags', function ($expression) {
      return "<?php echo tags($expression) ?>";
    });

    //$this->events();
    
    $this->loadViewsFrom( __DIR__.'/../../resources/views', 'altius');
  }

  protected function bootCommands() {
    if ($this->app->runningInConsole()) {
      $this->commands([
          
      ]);
    }
  }
   
  protected function bootRouting() {

      Route::middleware('web')
        ->group(__DIR__. '/../../routes/web.php');

      // ajax redirect handling for forms
      Route::pushMiddlewareToGroup('web',\Altius\Http\Middleware\Redirect::class);
      Route::pushMiddlewareToGroup('web',\Altius\Http\Middleware\UserActivity::class);
  
  }
      
  protected function registerAppPolicy($appPolicyClass) {
    $reflect = new \ReflectionClass($appPolicyClass);
    foreach($reflect->getMethods(\ReflectionMethod::IS_PUBLIC) as $m) {
      if(!$m->isStatic()) {
        Gate::define(\Str::kebab($m->name),$appPolicyClass .'@'.$m->name);
        
      }
    }
  }

  
}