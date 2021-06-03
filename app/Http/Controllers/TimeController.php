<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function timestamp($day, $month, $year)
    {
        return Carbon::parse($year . '-' . $month . '-' . $day)->timestamp;
    }

    public function this_timestamp()
    {
        return Carbon::now()->timestamp;
    }

    public function this_year()
    {
        return Carbon::now()->year;
    }
        
    public function this_month()
    {
        return Carbon::now()->month;
    }

    public function today()
    {
        return Carbon::now()->day;
    }

    public function this_quarter()
    {
        return Carbon::now()->quarter;
    }
   
}
