<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\alldistrict;
use App\category;

class CategoryController extends Controller
{
	public function index()
	{
		$categories = category::all();
		return view('Blog.category.index', compact('categories'));
	}
	
	
    public function create()
    {
		if (Auth::user()->hasAnyRoles(['admin', 'osp']))
		{
			return view('Blog.category.create');
		}
    }


    public function store(Request $request)
    {
        category::create(['name' => $request->blog_category]);
        return redirect ('/blog/category');
    }
    
    public function edit($id)
    {
		if (Auth::user()->hasAnyRoles(['admin', 'osp']))
		{
			$category = category::where('id', $id)->get();
			return view('Blog.category.edit', compact('category'));
		}
	}
	
	public function update(Request $request, $id)
	{
		category::where('id', $id)->update(['name' => $request->blog_category]);
        return redirect ('/blog/category');
	}
	
	public function destroy($id)
	{
		if (Auth::user()->hasAnyRoles(['admin', 'osp']))
		{
			category::where('id', $id)->delete();
			return redirect ('/blog/category');
		}
	}
}
