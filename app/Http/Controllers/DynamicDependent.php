<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DynamicDependent extends Controller
{
    function index()
    {
        $country_list = DB::table('country_state_city')
            ->groupBy('country')
            ->get();
        return view('dynamic_dependent')->with('country_list', $country_list);
    }
}
