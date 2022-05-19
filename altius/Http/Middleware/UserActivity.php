<?php

namespace Altius\Http\Middleware;


class UserActivity {

    public function handle($request, \Closure $next)
    {
        if(auth()->check()) {

            if(now()->startOfMinute()->notEqualTo(auth()->user()->last_activity) ) {
                auth()->user()->last_activity=now()->startOfMinute();
                auth()->user()->save();
            }
           
        }
        return $next($request);


    }

}
