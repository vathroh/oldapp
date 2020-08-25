<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\job_desc;
use App\allvillage;
use App\job_title;
use App\work_zone;
use App\User;


class profilController extends Controller
{
	    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

		$job_desc = job_desc::join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')
			->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
			->leftJoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
            ->where('job_descs.user_id', Auth::user()->id)->get()[0];

		return view('profil.index', compact(['job_desc']));
	}
	
	public function create()
	{
        $districts = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
        $job_titles = job_title::get();


		return view('profil.create', compact(['districts', 'job_titles']));
	}
	
	public function store(Request $request)
	{
		$level = DB::table('job_titles')->where('id', '=', $request->job_title)->get()->pluck('level');
		$work_zone_id = work_zone::where('level', $level)->where('district', $request->district)->get()->pluck('id')[0];
		
		job_desc::create([
			'user_id' 		=> Auth::user()->id,
			'work_zone_id' 	=> $work_zone_id,
			'job_title_id' 	=> $request->job_title
		]);
		
		return redirect ('/home');
	}
	
	public function edit($id)
	{
		$job_desc = job_desc::join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')
			->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
			->leftJoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
			->where('job_descs.user_id', Auth::user()->id)->get()[0];
		
	    $districts = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
        
        $job_titles = job_title::get();


		return view('profil.edit', compact(['job_desc', 'districts', 'job_titles']));
	}
	
	public function update(Request $request, $id)
    {
        $level = DB::table('job_titles')->where('id', '=', $request->job_title)->get()->pluck('level');
        $work_zone_id = work_zone::where('level', $level)->where('district', $request->district)->get()->pluck('id')[0];

		
		User::where('id', Auth::user()->id)->update([
			'name' => $request->username,
			'email' => $request->email,
			'nik' =>$request->nik
		]);
		
		job_desc::where('user_id', Auth::user()->id)->update([
			'user_id' 		=> Auth::user()->id,
			'work_zone_id' 	=> $work_zone_id,
			'job_title_id' 	=> $request->job_title
		]);
		
		return redirect('/profil');
	}
}
