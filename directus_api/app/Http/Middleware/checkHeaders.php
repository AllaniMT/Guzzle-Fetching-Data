<?php

namespace App\Http\Middleware;

use Closure;

class checkHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $variables = request()->headers;

       foreach ($variables as $key => $variable)
        {
            $arr[] = $key;
       }

        if(! in_array('x-syncwork-env', $arr))
        {
            return response()->json(['error' => 'error Message'],400);
        }else{
            return $next($request);
        }

    }
}
