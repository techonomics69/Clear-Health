<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\SubQuestionAnswer;
use Session;
use DB;

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
            $quizOrder[$key] = Quiz::where('category_id', $key)->OrderBy('id', 'ASC')->get()->pluck('order')->toArray();
        }
        return view('quiz.index', compact('quiz','category','quizOrder'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();
        $question = DB::table("quizzes")->pluck('question','id');
        return view('quiz.create', compact('category','question'));
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
            'option' => 'required',
            'status' => 'required|not_in:0', 
            //'category' => 'required',
            //'sub_heading' =>'required',  
            //'sub_question' => 'required',
            //'parent_question' => 'required',
            //'option_answer' => 'required',
            //'product_recommendation' => 'required',
            //'recommendation_product' => 'required',       
        ]);

        //$quiz = Quiz::create($request->all());

        $quiz = Quiz::create([
            'question' => $request->input('question'),
            'sub_heading' => $request->input('sub_heading'),
            'status' => $request->input('status'), 
            'option_type' => $request->input('option_type'),
            'option' => $request->input('option'),
            'sub_question'=> $request->input('sub_question'),
            'category_id' => $request->input('category_id') ,
            'use_for_recommendation' => $request->input('product_recommendation'),
            'recommendation_product' => $request->input('recommendation_product')
        ]);

        $quizzes =SubQuestionAnswer::create(['question_id' => $quiz['id'],
                'parent_question_id' => $request->input('parent_question'),
                'option_select'=>$request->input('option_answer') ]); 

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
        $question_select = SubQuestionAnswer::where('question_id',$quiz->id)
        ->join('quizzes','quizzes.id', '=', 'sub_question_answer.parent_question_id')
        ->select('sub_question_answer.option_select','quizzes.question')->get();

        //$tags = Tag::pluck('tag', 'id')->toArray();
        return view('quiz.show',compact('quiz','question_select'));
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
        //$select_option = explode(',',  $quiz->option);
        $question = DB::table("quizzes")->pluck('question','id');
        $question_select = SubQuestionAnswer::join('quizzes','quizzes.id', '=', 'sub_question_answer.question_id')
                    ->select('sub_question_answer.*')->get();

        $category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();
        return view('quiz.edit',compact('category','quiz','question','question_select'));
    }

    /**
     * Update the specified resource in storage.
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

        $quizzes = SubQuestionAnswer::where('question_id',$quiz->id)->update(['parent_question_id'=>$request['parent_question'],'option_select'=>$request['option_answer']]); 

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

    public function orderUpdate(Request $request)
    {
        $ids=$request['id'];
        foreach ($ids as $key => $value) 
            {
        $update = array('order'=>$value);
        $order = Quiz::where('id',$key)->update($update);
            }
    } 
   
    public function option(Request $request)
        {

        $option = DB::table("quizzes")->select('option')->where("id",$request->id)->first("option");
        $options = explode(',',$option->option);  
        return response()->json($options);
        } 
 
}
