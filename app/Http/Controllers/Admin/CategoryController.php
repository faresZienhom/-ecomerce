<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Traits\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    use Image;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $request = request();

        $categories = Category::with('parent')
        ->withCount([
            'products as products_number' => function($query) {
                $query->where('status', '=', 'active');
            }
        ])

        ->filter($request->query())
        ->orderBy('categories.name')
        ->paginate(); // Return Collection object


        return view('admin.pages.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();

        return view('admin.pages.categories.create',compact('parents','category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $imageName = $this->saveimage($request->image,'category','images/categories');

        Category::create([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'status'=>$request->status,
            'description'=>$request->description,
            'image'=>$imageName,
            'slug' => str::slug($request->post('name'))
        ]);
        return redirect()->route('dashboard.categories.index')
        ->with("success","category created successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.pages.categories.show',compact('category'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = Category::all();

        return view('admin.pages.categories.update',compact('category','parents'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if($request->hasFile('image')){

            $ext = $request->file('image')->getClientOriginalExtension();
            $newName = "category" . time() .rand(100,100000) . "." . $ext;
            $path =public_path("images/categories/". $category->image);
            if(file_exists($path)){
              unlink($path);
            }
            $request->file("image")->move(public_path("images/categories"),$newName);

          }

        $category->update([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'description'=>$request->description,
            'status'=>$request->status,
        ]);


        return redirect()->route('dashboard.categories.index')
        ->with("success","category updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Category $category)
    {

        $category -> delete();
        return redirect()->route('dashboard.categories.index');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('admin.pages.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
            ->with('succes', 'Category restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        $path =public_path("images/categories/" . $category->image);
        if(file_exists($path)){
          unlink($path);
        }

        return redirect()->route('categories.trash')
            ->with('succes', 'Category deleted forever!');
    }

}
