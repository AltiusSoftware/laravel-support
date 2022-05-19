<?php

namespace Altius\Http\Middleware;


class UserActivity {

    public function handle($request, \Closure $next)
    {
        if(auth()->check()) {

            if(auth()->user()->last_activity?->notEqualTo(now()->startOfMinute())) {
                auth()->user()->last_activity=now()->startOfMinute();
                auth()->user()->save();
            }
           
        }
        return $next($request);


    }

}
