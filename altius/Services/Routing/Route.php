<?php namespace Altius\Services\Routing;

use Altius\Services\Breadcrumbs;

class Route extends \Illuminate\Routing\Route {
    public function title($title=null) {
        app(Breadcrumbs::class)->title($this->getName(),$title);
        return $this;
    }
    public function parent($parent=null, $params=null){
        app(Breadcrumbs::class)->parent($this->getName(),$parent,$params);
        return $this;
    }

    public function post2() {
        !d($this->uri);
        return app('router')->lastGetPost($this->getName());

    
    }

    public $post=null;
    public function name($name)  {
        parent::name($name);


        if($this->post)
            $this->post->name("$name.post");
        return $this;

    }

    public function post(){

        return app('router')->post($this->uri,$this->getControllerMethod() . 'Post')
                    ->name($this->getName().'.post');

    }

    
}