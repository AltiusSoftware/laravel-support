<?php namespace Altius\Services\Routing;



class Router extends \Illuminate\Routing\Router {


    protected $model, $plural,$singular;


    public function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
                    ->setRouter($this)
                    ->setContainer($this->container);
    }
    

    public function crud($plural,$singular,$verbs=[]){
        
        $model =sprintf('{%s}',$singular);

        $this->get("/$plural",'index')
          ->name("$plural.index")
          ->title("models.$plural.plural")
          ->parent('home');
        
        $this->get("/$plural/create",'create')
          ->name("$plural.create")
          ->title('models.create')
          ->parent("$plural.index")
          ->post();
          
        $this->get("/$plural/$model",'record')
          ->name("$plural.record")
          ->title(fn($record) => $record->summary)
          ->parent("$plural.index");

          $verbs = array_merge($verbs, ['edit','delete']);
          

  
        
        foreach($verbs as $v) {
          $this->get("/$plural/$model/$v",'record' . ucwords($v))
            ->name("$plural.record.$v")
            ->title("models.$v")
            ->parent("$plural.record",fn($r)=>[$r])
            ->post();
        }
  

    }

}