<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\post_category;
use App\alldistrict;
use App\category;
use App\post;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');                
    }
    
    
    public function index()
    {
		if (Auth::user()->hasAnyRoles(['admin', 'blog']))
		{
		$posts = post::join('post_categories', 'posts.id', '=', 'post_categories.post_id')
            ->join('categories', 'post_categories.category_id', '=', 'categories.id')
            ->orderBy('posts.updated_at', 'desc')
			->get();
		} else {
		$posts = post::join('post_categories', 'posts.id', '=', 'post_categories.post_id')
            ->join('categories', 'post_categories.category_id', '=', 'categories.id')
            ->orderBy('posts.updated_at', 'desc')
            ->where('posts.user_id', Auth::user()->id)
			->get();
		}
		
		return view('Blog.post.index', compact(['posts']));
	}
		

    public function create() 
    {
		if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
		{
			$categories = category::all();        
			return view('Blog.post.create', compact(['categories']));
		}
    }

    public function store(Request $request)
    {
        $post_id = post::max('id') + 1;
        $slug = $post_id . '-' . Str::slug($request->post_title, '-');
        post::create([
            'slug'          => $slug,
            'title'         => $request->post_title,
            'body'          => $request->post_content,
            'published'     => $request->published,
            'publish_date'  => now(),
            'keyword'       => $request->post_keyword,
            'user_id'       => Auth::user()->id
        ]);



        if($request->hasFile('image1'))
        {
            $extension = $request->image1->getClientOriginalExtension();
            $file_name = $slug . '-' . 'image1' . '.' . $extension;
            Storage::disk('public')->putFileAS('blog', $request->image1, $file_name);

            post::where('id', $post_id)->update([
                'image1'    => $file_name
            ]);
        }
        if($request->hasFile('image2'))
        {
            $extension = $request->image2->getClientOriginalExtension();
            $file_name = $slug . '-' . 'image2' . '.' . $extension;
            Storage::disk('public')->putFileAS('blog', $request->image2, $file_name);

            post::where('id', $post_id)->update([
                'image2'    => $file_name
            ]);
        }
        if($request->hasFile('image3'))
        {
            $extension = $request->image3->getClientOriginalExtension();
            $file_name = $slug . '-' . 'image3' . '.' . $extension;
            Storage::disk('public')->putFileAS('blog', $request->image3, $file_name);

            post::where('id', $post_id)->update([
                'image3'    => $file_name
            ]);
        }
        if($request->hasFile('image4'))
        {
            $extension = $request->image4->getClientOriginalExtension();
            $file_name = $slug . '-' . 'image4' . '.' . $extension;
            Storage::disk('public')->putFileAS('blog', $request->image4, $file_name);

            post::where('id', $post_id)->update([
                'image4'    => $file_name
            ]);
        }

        post_category::create([
            'post_id'   => $post_id,
            'category_id'   => $request->post_category
        ]);

        return redirect('/blog/post');
    }
    
    
    public function edit($id)
    {
		if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
		{
		$categories = category::all();
        $post = post::where('posts.id', $id)
                        ->where('user_id', Auth::user()->id)
						->join('post_categories', 'posts.id', '=', 'post_categories.post_id')
						->join('categories', 'post_categories.category_id', '=', 'categories.id')
						->first();
		return view('Blog.post.edit', compact(['post', 'categories']));
		}
    }


    public function update(Request $request, $id)
    {
        $slug = $id . '-' . Str::slug($request->post_title, '-');
        post::where('id', $id)->update([
            'slug'          => $slug,
            'title'         => $request->post_title,
            'body'          => $request->post_content,
            'published'     => $request->published,
            'publish_date'  => now(),
            'keyword'       => $request->post_keyword,
        ]);

        post_category::where('post_id', $id)->update([
            'category_id'   => $request->post_category
        ]);


        return redirect('/blog/post');

    }


    public function destroy($id)
    {
		if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
		{
        post::where('id', $id)->delete();
        return redirect('/blog/post');
		}
    }


    public function editImage1($id, $img)
    {
        $image = $img;
        $post = post::where('id', $id)->first();
        return view('Blog.post.image1edit', compact(['post', 'image']));

    }


    public function deleteImage1(Request $request, $id, $img)
    {
        If ($request->has('delete'))
        {
            $file = post::where('id', $id)->pluck($img)->first();
            post::where('id', $id)->update([$img  =>""]);
            Storage::disk('public')->delete('/storage/blog/' . $file);
        }
        
        if ($request->has('update')) 
        {   
            $slug = post::where('id', $id)->pluck('slug')->first();
            $extension = $request->image->getClientOriginalExtension();
            $file_name = $slug . '-' . $img . '.' . $extension;
            Storage::disk('public')->putFileAS('blog', $request->image, $file_name);
            post::where('id', $id)->update([
                $img    => $file_name
            ]);
        }

        return redirect('/blog/post/' . $id . '/edit');    
    }
}
