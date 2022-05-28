<?php

namespace App\Http\Middleware;

use App\Models\Debt;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PayDebtPayedMiddleware
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
        $id = Crypt::decrypt($request->route()->debt);
        $debt = Debt::findOrFail($id);
        if($debt->status!=1) {
            abort(403, 'Acción no autorizada.');
        } else {
            return $next($request);
        }
    }
}
