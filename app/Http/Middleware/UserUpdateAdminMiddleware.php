<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserUpdateAdminMiddleware
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
        $id = Crypt::decrypt($request->id);
        $user = User::find($id);
        $roles = Auth::user()->roles;
        $own_array = [];
        $user_roles = [];
        foreach ($roles as $v) {
            array_push($own_array,$v->id);
        }
        foreach ($user->roles as $v) {
            array_push($user_roles,$v->id);
        }
        if (in_array(1,$user_roles)) {
            if(in_array(1,$own_array)) {
                return $next($request);
            } else {
                abort(403, 'Acción no autorizada.');
            }
        }
        return $next($request);
    }
}
