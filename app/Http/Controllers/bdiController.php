<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($year)
    {
       return view('bdi.index'); 
    }
}
