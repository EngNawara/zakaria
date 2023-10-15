<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(5);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);

        $category->image = $fileName;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category Created Successfully');
    }

    public function show(Category $category)
    {
        dd($category);
    }

    public function edit($id)
    {
        // dd($category);
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);

        $category->image = $fileName;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category Created Successfully');

    }

    public function destroy(Category $category)
    {
        //
    }

    public function single($slug)
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        $courses = $category->courses()->with('teacher:id,name,image,slug', 'students:id')->orderBy('created_at', 'DESC')->paginate(6);

        // dd($category);
        return view(
            'jambasangsang.frontend.courses.index',
            ['courses' => $courses]
        );
    }

    // , function (Builder $query) use ($slug) {
    //     $query->whereSlug($slug);
    // }
}
