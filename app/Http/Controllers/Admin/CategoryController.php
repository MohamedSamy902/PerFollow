<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::latest()->paginate(16);
        return view('admin.category.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:categories',
            'status'      => 'required',
        ]);

        $category = new Category();
        $category->name        = $request->name;
        $category->slug        = Str::slug($request->name);
        $category->status      = $request->status;
        $category->save();
       
        return back()->with('success', 'Category added successfully');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|unique:categories,name,'.$category->id,
            'status'      => 'required',
        ]);

        $category->name        = $request->name;
        $category->slug        = Str::slug($request->name);
        $category->status      = $request->status;
        $category->save();

        return back()->with('success', 'Category updated successfully');
    }


    public function statusChange($id)
    {
        $category = Category::findOrFail($id);
        if ($category->status == 0)  $status = 1;
        else $status = 0;
        $category->status = $status;
        $category->save();

        return back()->with('success', 'Category status changed successfully');
    }
}
