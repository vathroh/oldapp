<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Middleware;
use App\alldistrict;
use App\job_title;
use App\work_zone;
use App\job_desc;
use App\Role;
use App\User;
use Gate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = user::leftjoin('job_descs', 'users.id', '=', 'job_descs.user_id')
			->leftjoin('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')
			->leftjoin('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
			->leftjoin('alldistricts', 'work_zones.district', '=', 'alldistricts.kode_kab')			
			->select('*', 'users.id')->orderBy('users.id')->get();	
			
		$kabupaten=alldistrict::get();
		
        return view('admin.users.index',  compact(['users', 'kabupaten']));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
		$user = user::where('users.id', $user->id)
			->leftjoin('job_descs', 'users.id', '=', 'job_descs.user_id')
			->leftjoin('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')
			->leftjoin('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
			->leftjoin('alldistricts', 'work_zones.district', '=', 'alldistricts.kode_kab')			
			->select('*', 'users.id')->get()[0];
			
		$job_titles = job_title::get();

		$kabupaten = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
            
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }

        $roles = Role::all();
        return view('admin.users.edit', compact(['user', 'kabupaten', 'job_titles']))->with([

            'roles' => $roles
        ]);
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
		
        
        $level = DB::table('job_titles')->where('id', '=', $request->job_title)->get()->pluck('level');
		$work_zone_id = work_zone::where('level', $level)->where('district', $request->district)->get()->pluck('id')[0];
		

		if(job_desc::where('user_id', $user->id)->exists()){		
			job_desc::where('user_id', $user->id)->update([
				'user_id' 		=> $user->id,
				'work_zone_id' 	=> $work_zone_id,
				'job_title_id' 	=> $request->job_title
			]);
		} else {
			job_desc::create([
				'user_id' 		=> $user->id,
				'work_zone_id' 	=> $work_zone_id,
				'job_title_id' 	=> $request->job_title
			]);
		};

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
		$user = user::where('users.id', $user->id)
			->leftjoin('job_descs', 'users.id', '=', 'job_descs.user_id')
			->leftjoin('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')
			->leftjoin('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
			->leftjoin('alldistricts', 'work_zones.district', '=', 'alldistricts.kode_kab')			
			->select('*', 'users.id')->get()[0];
			
		$job_titles = job_title::get();

		$kabupaten = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
            
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }

        $roles = Role::all();
        return view('admin.users.show', compact(['user', 'kabupaten', 'job_titles']))->with([

            'roles' => $roles
        ]);
        
        
    }

    public function destroy(User $user)
    {
        if (Gate::denies('delete-users')) {
            return redirect(route('admin.users.index'));
        }

        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
