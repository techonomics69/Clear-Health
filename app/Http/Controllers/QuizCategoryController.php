<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizCategory;

class QuizCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:quizCategory-list|quizCategory-create|quizCategory-edit|quizCategory-delete', ['only' => ['index','store']]);
         $this->middleware('permission:quizCategory-create', ['only' => ['create','store']]);
         $this->middleware('permission:quizCategory-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:quizCategory-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = QuizCategory::OrderBy('id', 'ASC')->paginate(50);

        return view('quizCategories.index', compact('categories'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quizCategories.create');
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
            'name' => 'required',           
        ]);

        $Category = QuizCategory::create($request->all());
                
        toastr()->success('Quiz Category created successfully');

        return redirect()->route('quizCategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quizCategory = QuizCategory::find($id);

        return view('quizCategories.edit',compact('quizCategory'));
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
        $this->validate($request, [
            'name' => 'required'             
        ]); 
        
        $quizCategory = QuizCategory::find($id);
        
        $quizCategory->update($request->all());       
                
        toastr()->success('Quiz Category updated successfully');

        return redirect()->route('quizCategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quizCategory = QuizCategory::find($id);
        $quizCategory->delete();       
            
        toastr()->success('Quiz Category deleted successfully');
        return redirect()->route('quizCategory.index');
    }
}
