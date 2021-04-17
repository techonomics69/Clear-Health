<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizCategory;
use Session;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:quiz-list|quiz-create|quiz-edit|quiz-delete', ['only' => ['index','store']]);
         $this->middleware('permission:quiz-create', ['only' => ['create','store']]);
         $this->middleware('permission:quiz-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:quiz-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = QuizCategory::pluck('name', 'id')->toArray();
        foreach ($category as $key => $value) {
            $quiz[$key][] = Quiz::where('category_id', $key)->OrderBy('id', 'ASC')->get();
        }
        return view('quiz.index', compact('quiz','category'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();

        return view('quiz.create', compact('category'));
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
            'question' => 'required',  
            'status' => 'required|not_in:0',         
        ]);

        $quiz = Quiz::create($request->all());
                
        toastr()->success('Quiz created successfully');

        Session::put('que_current_tab', $request['category_id']);

        return redirect()->route('quiz.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::find($id);
        //$tags = Tag::pluck('tag', 'id')->toArray();
        return view('quiz.show',compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::find($id);
        $category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();
        return view('quiz.edit',compact('category','quiz'));
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
            'question' => 'required',  
            'status' => 'required|not_in:0',          
        ]); 
        
        $quiz = Quiz::find($id);
        
        $quiz->update($request->all());  

        Session::put('que_current_tab', $request['category_id']);     
                
        toastr()->success('Quiz updated successfully');

        return redirect()->route('quiz.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);

        Session::put('que_current_tab', $quiz['category_id']);  

        $quiz->delete();       
            
        toastr()->success('Question deleted successfully');
        return redirect()->route('quiz.index');
    }
}
