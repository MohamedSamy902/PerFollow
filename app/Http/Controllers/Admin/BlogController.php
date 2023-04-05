<?php

namespace App\Http\Controllers\Admin;
use App\Models\Blog;
use Illuminate\Support\Str;
use App\Helpers\MediaHelper;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Requests\Admin\BlogRequest;

class BlogController extends Controller
{

   public function __construct(BlogResource $resource)
   {
       $this->resource = $resource;
   }


    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(15);
        return view('admin.blog.index',compact('blogs'));
    }

  
    public function create()
    {
        $categories = BlogCategory::where('status',1)->get(); 
        return view('admin.blog.create',compact('categories'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'photo'       => 'required|image|mimes:jpeg,jpg,png,svg',
            'title'       => 'required|max:255|unique:blogs',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $blog = new Blog;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->description = clean($request->description);
        if($request->photo) $blog->photo = MediaHelper::handleMakeImage($request->photo);
        $blog->save();
        return back()->with('success','New blog has been created');
    }

  
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status',1)->get(); 
        return view('admin.blog.edit',compact('blog','categories'));
    }
    
    public function update(Request $request,$id)
    {
        $request->validate([
            'photo'       => 'image|mimes:jpeg,jpg,png,svg',
            'title'       => 'required|max:255|unique:blogs,title,'.$id,
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->description = clean($request->description);
        if($request->photo) $blog->photo = MediaHelper::handleMakeImage($request->photo);
        $blog->save();
        
        return back()->with('success','Blog has been updated');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success','Blog has been deleted');
    }
}
