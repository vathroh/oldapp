<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\allvillage;
use App\User;

class hrmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $myZones    = explode(", ", User::find( Auth::user()->id )->areaKerja()->pluck('zone')->first());
        $kabupaten  = allvillage::distinct()->whereIn('KD_KAB', $myZones )->select('KD_KAB', 'NAMA_KAB')->get();

        $users      = [];
        foreach($kabupaten as $kab)
        {
            $users[$kab->KD_KAB] = $kab->jobDesc()->orderBy('job_title_id')->get();
        }

        return view('admin.users.hrm', compact(['kabupaten', 'users']));
    }
}
