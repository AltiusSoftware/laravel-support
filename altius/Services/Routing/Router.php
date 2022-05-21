<?php namespace Altius\Services\Routing;



class Router extends \Illuminate\Routing\Router {
    
    public function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
                    ->setRouter($this)
                    ->setContainer($this->container);
    }
    


    public function getPost($uri,$action=null){
       $get = $this->get($uri,$action);
       $get->post  = $this->post($uri,$action.'Post');

       return $get;

    
    }


}