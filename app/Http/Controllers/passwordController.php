<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\work_zone;
use App\User;

class passwordController extends Controller
{
    public function admin($id)
    {
		$user = User::find($id);
		$kabupaten = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
            
		return view('admin.password.admin')->with([
			'user' => $user,
			'kabupaten' => $kabupaten
		]);
	}
	
	public function storeByAdmin(Request $request, $id)
    {
        If($request->change_password == ''){
            return redirect('/pass-by-admin/' . $id . '/edit');
        } else {

		User::where('id', $id)->update([
			'password' => Hash::make($request->change_password)
		]);

        return redirect (route('admin.users.index'));
        
        }
    }
	
	public function user()
    {
		$kabupaten = work_zone::select('work_zones.district', 'NAMA_KAB')
            ->leftJoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
            ->distinct()->get();
		return view('admin.password.user')->with([
			'kabupaten' => $kabupaten
		]);;
	}
	
	public function storeByUser(Request $request)
    {
        If($request->change_password == ''){
            return redirect('/pass-by-user/' . Auth::user()->id . '/edit');
        } else {

		User::where('id', Auth::user()->id)->update([
			'password' => Hash::make($request->change_password)
		]);
        return redirect ('/home');
        
    	}
	
    }
}
