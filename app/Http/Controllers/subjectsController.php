<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\categories_of_library;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\activity;
use App\subject;
use App\library;
use App\User;

class subjectsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
		$instructors = User::orderBy('name')->get();
        $subjects = subject::join('activities', 'subjects.activity_id', '=', 'activities.id')
			->select("*", "subjects.id")->get();
			
        return view('activities.subjects.index', compact(['subjects', 'instructors']));  
    }
    
    
    public function create() 
    {
		$instructors = User::orderBy('name')->get();
		$activities = activity::all();
        return view('activities.subjects.create', compact(['activities', 'instructors']));
    }
    
    
    public function store(Request $request)
    {
		$activity = activity::where('id', $request->activity)->pluck('name')->first();
		$library_category_id = categories_of_library::where('name', 'PELATIHAN')->pluck('id')->first();
		
		if($request->hasFile('file'))
		{
			$id = subject::max('id');
            $extension = $request->file->getClientOriginalExtension();
            $file_name = Str::slug($request->subject, '_') . '.' . $extension;            
            
            Storage::disk('public')->putFileAS('library', $request->file, $file_name);            
			
            library::create([
            'description'   	=> $activity,
            'subject'       	=> $request->subject,
            'category_id'		=> $library_category_id,
            'link'         		=> $request->link,
            'file' 				=> $file_name
			]);	
		}
		
		if($request->link != "")
		{
            library::create([
            'description'   	=> $activity,
            'subject'       	=> $request->subject,
            'category_id'		=> $library_category_id,
            'link'         		=> $request->link,
			]);	
		}
		
		$library_id = library::where('description', $activity)->where('subject', $request->subject)->pluck('id')->first();
		
		subject::create([
			'library_id'		=> $library_id,			
			'date' 				=> $request->date,			
			'subject' 			=> $request->subject,
			'add_info' 			=> $request->add_info,
			'activity_id' 		=> $request->activity,			
			'instructor1_id' 	=> $request->instructor1,
			'instructor2_id' 	=> $request->instructor2,
			'evaluation_sheet' 	=> $request->evaluation_sheet,
			'start_time' 		=> date("H:i", strtotime($request->start_time)),
			'finish_time' 		=> date("H:i", strtotime($request->finish_time))
		]);
				
        return redirect ('/subjects');
	}


	public function edit($id)
    {
		$instructors = User::orderBy('name')->get();
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
			$activities = activity::all();
			$subject = subject::where('subjects.id', $id)->join('activities', 'subjects.activity_id', '=', 'activities.id')
				->select("*", "subjects.id")->first();
            return view('activities.subjects.edit', compact(['subject', 'activities', 'instructors']));                            
        }
        
        return redirect('/subjects');
    }
    
    public function update(Request $request, $id)
    {
		$activity = activity::where('id', $request->activity)->pluck('name')->first();
	 	$library_category_id = categories_of_library::where('name', 'PELATIHAN')->pluck('id')->first();
		
		if($request->hasFile('file'))
		{
			$id = subject::max('id');
            $extension = $request->file->getClientOriginalExtension();
            $file_name = Str::slug($request->subject, '_') . '.' . $extension;            
            
            Storage::disk('public')->putFileAS('library', $request->file, $file_name);            
			
            library::create([
            'description'   	=> $activity,
            'subject'       	=> $request->subject,
            'category_id'		=> $library_category_id,
            'link'         		=> $request->link,
            'file' 				=> $file_name
			]);	
		}
		
		
		if($request->link != "")
		{
            library::create([
            'description'   	=> $activity,
            'subject'       	=> $request->subject,
            'category_id'		=> $library_category_id,
            'link'         		=> $request->link,
			]);	
		}
		
		$library_id = library::where('description', $activity)->where('subject', $request->subject)->pluck('id')->first();
		
        subject::where('id', $id)->update([
			'library_id'		=> $library_id,			
			'date' 				=> $request->date,			
			'subject' 			=> $request->subject,
			'add_info' 			=> $request->add_info,
			'activity_id' 		=> $request->activity,			
			'instructor1_id' 	=> $request->instructor1,
			'instructor2_id' 	=> $request->instructor2,
			'evaluation_sheet' 	=> $request->evaluation_sheet,
			'start_time' 		=> date("H:i", strtotime($request->start_time)),
			'finish_time' 		=> date("H:i", strtotime($request->finish_time))
		]);
        
        return redirect ('/subjects');                
    }


    public function destroy($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
            subject::where('id', $id)->delete();                                         
        }
        
        return redirect('/subjects');                        
    }
}
