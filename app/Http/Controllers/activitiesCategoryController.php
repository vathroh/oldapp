<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\activities_category;

class activitiesCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $categories = activities_category::paginate(10);
        return view('activities.category.index', compact('categories'));
    }


    public function create()
    {
        return view('activities.category.create');
    }


    public function store(Request $request)
    {
        activities_category::create(['name' => $request->library_category]);
        return redirect('/activities-category');
    }


    public function edit($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp'])) {
            $category = activities_category::where('id', $id)->first();
            return view('activities.category.edit', compact('category'));
        }
    }


    public function update(Request $request, $id)
    {
        activities_category::where('id', $id)->update(['name' => $request->library_category]);
        return redirect('/activities-category');
    }


    public function destroy($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp'])) {
            activities_category::where('id', $id)->delete();
            return redirect('/activities-category');
        }
    }
}
