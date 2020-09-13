<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\categories_of_library;
use App\library;
use App\post;
use App\User;

class blogController extends Controller
{
	public function home()
    {
		$categories = categories_of_library::take(2)->get();
		$libraries = library::orderBy('updated_at', 'desc')->paginate(5);
        $post_array = $this->post_data();        
        $myCollectionObj = collect($post_array);
        $posts = $this->home_paginate($myCollectionObj);
        
        return view('Blog.index', compact(['posts', 'libraries', 'categories']));
    }
    
    public function index()
    {
		$categories = categories_of_library::take(2)->get();
		$libraries = library::orderBy('updated_at', 'desc')->paginate(5);
        $post_array = $this->post_data();        
        $myCollectionObj = collect($post_array);
        $posts = $this->paginate($myCollectionObj);
        
        $posts->withPath('/blog-osp1');
        
        return view('Blog.blog', compact(['posts', 'libraries', 'categories']));
    }
    
    public function show($id)
    {
		$categories = categories_of_library::take(2)->get();
		$libraries = library::orderBy('updated_at', 'desc')->paginate(5);
        $post_array = $this->post_data();        
        $myCollectionObj = collect($post_array);
        $post =  $myCollectionObj->where('id', $id);
        
        return view('Blog.single', compact(['post', 'libraries', 'categories']));
    }
    
    
    public function library($library)
    {	
		$categories = categories_of_library::take(2)->get();		
		$category_id = categories_of_library::where('name', Str::upper($library))->pluck('id')->first();		
		$libraries = library::select('libraries.id', 'subject', 'description', 'category_id', 'file', 'link', 'name')
						->join('categories_of_libraries', 'libraries.category_id', '=', 'categories_of_libraries.id')
						->orderBy('libraries.updated_at', 'desc')->paginate(10);
						
        return view('Blog.library', compact(['categories','library', 'libraries', 'category_id']));
	}
	
	
	public function single_library($id, $library)
    {	
		$categories = categories_of_library::take(2)->get();
		$libraries = library::orderBy('updated_at', 'desc')->paginate(5);
		 $library = library::where('id', $id)->first();
        return view('Blog.single_library', compact(['library', 'libraries', 'categories']));
	}
	
    
    public function post_data()
    {
		return DB::select('select posts.id, posts.slug, posts.title, posts.body, posts.updated_at, posts.image1, posts.image2, posts.image3, posts.image4, 
                    users.name, job_titles.job_title, alldistricts.nama_kab, DAY(posts.updated_at) as tanggal_update, MONTHNAME(posts.updated_at) as bulan_update,
                    YEAR(posts.updated_at) as tahun_update, SUBSTRING_INDEX(body, " ", 70) as exerpt from posts
                    JOIN users ON posts.user_id = users.id
                    JOIN job_descs ON posts.user_id = job_descs.user_id
                    JOIN job_titles ON job_descs.job_title_id = job_titles.id
                    JOIN work_zones ON job_descs.work_zone_id = work_zones.id
                    LEFT JOIN alldistricts ON work_zones.district = alldistricts.kode_kab
                    WHERE posts.published = 1
                    ORDER BY posts.updated_at DESC
                    ');
    }

    public function home_paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collectio ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collectio ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
