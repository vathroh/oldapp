<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class projectActivityParticipantMiddleware
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
        $array = $request->route()->parameters();

        $role = Auth::user()->ActivityParticipant->where('activity_id', $request->route(array_keys($array)[0]));

        if ($role->whereIn('role', 'PESERTA')->first()) {
            return $next($request);
        } else {
            return redirect('/dashboard');
        }
    }
}
