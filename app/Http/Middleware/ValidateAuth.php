<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ValidateAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = auth()->user()->id;
        $url = Route::current()->uri();
        if($url=='/' && $id){
            return redirect()->route('home');
        } else if($url!='/' && $id) {
            return $next($request);
        }
    }
}
