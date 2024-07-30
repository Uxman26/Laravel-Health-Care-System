<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Session;
class Language  
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
      if(Session::has('locale'))
      {
        // Session::put('locale','en');
          App::setLocale(Session::get('locale'));
      }else{
        Session::put('locale','en');
        App::setLocale(Session::get('locale'));
      }
      return $next($request);
    }

}