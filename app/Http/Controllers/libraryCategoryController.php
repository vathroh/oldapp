<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\library;
use App\categories_of_library;

class libraryCategoryController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $categories = categories_of_library::paginate(10);
        return view('library.category.index', compact('categories')); 
    }

    public function create()
    {
        return view('library.category.create');
    }
    
    public function store(Request $request)
    {
        categories_of_library::create(['name' => $request->library_category]);
        return redirect ('/library-category');
    }
    
    public function edit($id)
    {
		if (Auth::user()->hasAnyRoles(['admin', 'osp']))
		{
			$category = categories_of_library::where('id', $id)->first();
			return view('library.category.edit', compact('category'));
		}
	}
	
	
	public function update(Request $request, $id)
	{
		categories_of_library::where('id', $id)->update(['name' => $request->library_category]);
        return redirect ('/library-category');
	}
	    
    
    public function destroy($id)
	{
		if (Auth::user()->hasAnyRoles(['admin', 'osp']))
		{
			categories_of_library::where('id', $id)->delete();
			return redirect ('/library-category');
		}
	}
    
}
