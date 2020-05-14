<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;


class CheckUrl
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
        /*
        if(env('APP_ENV') == 'local')
        {
            $client = new Client();
            $request = $client->get(env('APP_DIRECTUSAPI'));
            $data = json_decode($request->getBody());
            $dates = $data->data;
            foreach ($dates as $date)
            {
                $est = $date->status;
                dd($est);
            }
            }
        */
        /*
*/
        /*
        $url = url()->current();
        $slice = Str::before($url, 'news');
        if(! Str::contains($slice, env('APP_BASEURL')))
        {
            abort(403);
        }
        */
        return $next($request);
    }

}
