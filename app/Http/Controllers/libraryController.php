<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\categories_of_library;
use App\library_category;
use App\library;

class libraryController extends Controller
{
    public function index()
    {
		$libraries = library::select('libraries.id', 'libraries.subject', 'libraries.description', 'libraries.file', 
		'libraries.link', 'categories_of_libraries.name'
		)->join('categories_of_libraries', 'libraries.category_id', '=', 'categories_of_libraries.id')->paginate(10);

        return view('library.index', compact('libraries'));
    }


    public function create() 
    {
		$categories = categories_of_library::all();
        return view('library.create', compact('categories'));
    }


    public function store(Request $request)
    {

        library::create([
            'subject'       => $request->subject,
            'description'   => $request->description,
            'category_id'	=> $request->category,
            'link'          => $request->link
        ]);

        if($request->hasFile('file'))
        {
            $id = library::max('id');
            $extension = $request->file->getClientOriginalExtension();
            $file_name = Str::slug($request->subject, '_') . '.' . $extension;
            Storage::disk('public')->putFileAS('library', $request->file, $file_name);
            library::where('id', $id)->update(['file' => $file_name ]);
        }

        return redirect('/pustaka');
    }


    public function edit($id)
    {
		$categories = categories_of_library::all();
		
        $library = library::where('libraries.id', $id)->select('libraries.id', 'libraries.subject', 'libraries.description', 
			'libraries.file', 'libraries.link', 'libraries.category_id', 'categories_of_libraries.name'
			)->join('categories_of_libraries', 'libraries.category_id', '=', 'categories_of_libraries.id')->first();
			
        return view('library.edit', compact(['library', 'categories']));
    }
    
    public function update(Request $request, $id)
    {
        library::where('id', $id)->update([
            'subject'       => $request->subject,
            'description'   => $request->description,
            'category_id'	=> $request->category,
            'link'          => $request->link
        ]);
        
        if($request->hasFile('file'))
        {
            $extension = $request->file->getClientOriginalExtension();
            $file_name = Str::slug($request->subject, '_') . '.' . $extension;
            Storage::disk('public')->putFileAS('library', $request->file, $file_name);
            library::where('id', $id)->update(['file' => $file_name ]);
        }
        
        return redirect('/pustaka');
    }


    public function destroy($id)
    {
        library::where('id', $id)->delete();
        return redirect('/pustaka');
    }


    public function deleteFile($id, $file)
    {
        Storage::disk('public')->delete('/storage/library/' . $file);
        library::where('id', $id)->update([
            'file'          => ""
        ]);
        return redirect('/pustaka/' . $id . '/edit');
    }
}
