<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\allvillage;
use App\job_desc;
use App\job_title;
use App\User;

class hrmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fasilitators(){
        return new UserController;
    }

    public function users()
    {

        $myZones    = explode(", ", job_desc::where('user_id', Auth::user()->id)->first()->areaKerja->zone);
        $kabupaten  = allvillage::distinct()->whereIn('KD_KAB', $myZones)->select('KD_KAB', 'NAMA_KAB')->get();

        $users      = [];
        foreach ($kabupaten as $kab) {
            $users[$kab->KD_KAB] = $kab->jobDesc()->orderBy('job_title_id')->get();
        }

        return [$users, $kabupaten];
    }

    public function index()
    {
        $kabupaten  = $this->users()[1];
        $users      = $this->users()[0];
        return view('admin.users.hrm', compact(['kabupaten', 'users']));
    }

    public function rekap()
    {
        $kabupaten  = $this->users()[1];
        $users      = $this->users()[0];
        return view('admin.users.rekap', compact(['kabupaten', 'users']));
    }

    public function userList($district, $jobTitleId)
    {
        $users  = $this->users()[0][$district]->where('job_title_id', $jobTitleId);
        return view('admin.users.userDetails', compact(['users']));
    }

    public function hrm(){
        return $this->fasilitators()->users_now();
    }
}
