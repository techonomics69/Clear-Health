<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::OrderBy('order', 'ASC')->paginate(50);

        return view('categories.index', compact('categories'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name|regex:/^[\pL\s\-]+$/u',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'order' => 'required|numeric|min:1'            
        ]);
        $imageName = time().'.'.$request->image->extension();

        $path = public_path().'/images/Categories';

        if (! File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $request->image->move(public_path('images/Categories'), $imageName);

        $Category = Category::create(['name' => $request->input('name'),'image' => $imageName, 'order' => $request->input('order')]);
                
        toastr()->success('Category created successfully');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        
        return view('categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        
        return view('categories.edit',compact('category')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id.'|regex:/^[\pL\s\-]+$/u',  
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',          
            'order' => 'required|numeric|min:1'            
        ]);
        
        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Categories';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Categories'), $imageName);

            $oldImg = $path.'/'.$category->image;

            if (File::exists($oldImg)) : // unlink or remove previous image from folder
                unlink($oldImg);
            endif;

            $category->image = $imageName;
        endif;

        $category->name = $request->input('name');
        $category->order = $request->input('order');
        $category->save();       
                
        toastr()->success('Category updated successfully');

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        // unlink or remove previous image from folder
        $path = public_path().'/images/Categories';
        $oldImg = $path.'/'.$category->image;
            if (File::exists($oldImg)) : 
                unlink($oldImg);
            endif;
            
        toastr()->success('Category deleted successfully');
        return redirect()->route('categories.index');
    }
}
