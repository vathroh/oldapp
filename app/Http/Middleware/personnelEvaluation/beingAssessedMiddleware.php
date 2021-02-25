<?php

namespace App\Http\Middleware\personnelEvaluation;

use App\personnel_evaluation_value;
use Closure;
use Illuminate\Support\Facades\Auth;

class beingAssessedMiddleware
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
        $evaluationValue = personnel_evaluation_value::find($request->route(array_keys($array)[0]));
        if ($evaluationValue->userId == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect('personnel-evaluation');
        }
    }
}
