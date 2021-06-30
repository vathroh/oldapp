<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kabupaten;

class FasilitatorController extends Controller
{
    public function user(){
        return new UserController;
    }

    public function fasilitators()
    {
        return $this->user()->users_now();
    }

    public function index()
    {
        $fasilitators = $this->fasilitators()->sortBy('tim');
        $districts = kabupaten::all();

        return view('admin.fasilitator.index', compact(['fasilitators', 'districts']));

    }

    public function edit($user_id)
    {
        
return        $fasilitator = $this->fasilitator($user_id);
        return view('admin.fasilitator.edit', compact('fasilitator'));
    }

    public function fasilitator($user_id){
        return $this->user()->user_now($user_id);
    }


}
