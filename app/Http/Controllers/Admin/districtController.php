<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\kabupaten;
use Illuminate\Http\Request;

class districtController extends Controller
{
    public function index()
    {
        $districts = kabupaten::all();
        return view('admin.district.index', compact('districts'));
    }

    public function show()
    {
        return view('admin.district.show', compact('districts'));
    }
}
