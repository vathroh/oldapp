<?php

namespace App\Http\Middleware;

use Closure;
use illuminate\Support\Facades\Auth;

class projectActivityInstructorMiddleware
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

        if ($role->whereIn('role', 'PEMANDU')->first()) {
            return $next($request);
        } else {
            return redirect('/activities');
        }
    }
}
