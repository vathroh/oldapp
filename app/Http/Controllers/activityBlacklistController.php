<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class activityBlacklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
		return view('activities.blacklist.index');
	}
}
