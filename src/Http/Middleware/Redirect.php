<?php

namespace Altius\Http\Middleware;


class Redirect {

    public function handle($request, \Closure $next)
    {
       $ret = $next($request);
       if($request->ajax()) {
            switch(get_class($ret)) {
                case 'Illuminate\Http\RedirectResponse':
                return response()->json(
                    [ 'redirect' => $ret->getTargetUrl()]);
        }
       };
       return $ret;

    }

}
