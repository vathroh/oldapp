<?php

namespace App\Http\Controllers\projectActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\activity;
use Carbon\Carbon;

class AgendaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
	    $Upcoming = activity::whereDate('start_date', '>', Carbon::now())->get();
	    
	    $todayActivities = activity::whereDate('start_date', '<=', Carbon::now())->whereDate('finish_date', '>=', Carbon::now() )->get();

	    return view('activities.agenda', compact(['Upcoming', 'todayActivities']));
    }
}
