<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\allvillage;

class hrmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kabupaten = allvillage::distinct()->select('KD_KAB', 'NAMA_KAB')->get();

        $users = [];
        foreach($kabupaten as $kab)
        {
            $users[$kab->KD_KAB] = $kab->jobDesc()->orderBy('job_title_id')->get();
        }

        return view('admin.users.hrm', compact(['kabupaten', 'users']));
    }
}
