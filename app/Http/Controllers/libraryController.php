<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\library;

class libraryController extends Controller
{
    public function index()
    {
        $libraries = library::all();
        return view('library.index', compact('libraries'));
    }



    public function create() 
    {
        return view('library.create');
    }


    public function store(Request $request)
    {
        library::create([
            'subject'       => $request->subject,
            'description'   => $request->description,
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
        $library = library::where('id', $id)->first();
        return view('library.edit', compact('library'));
    }


    public function destroy($id)
    {
        library::where('id', $id)->delete();
        try{
            Storage::disk('public')->delete('/storage/blog/' . $file);
        } catch(\Exeption $e){
            return $e->getMessage();
        }
        return redirect('/pustaka');
    }


    public function deleteFile($id, $file)
    {
        Storage::disk('public')->delete('/storage/library/uji_coba_pustaka_baru.png');
//        return redirect('/pustaka/' . $id . '/edit');
    }
}
