<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Quiz;
use App\Models\QuizCategory;
use Validator;

   
class QuizController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quiz = Quiz::where('status','1')->get();
        
        return $this->sendResponse($quiz, 'Quiz retrieved successfully.');
    }

    public function show($id)
    {
        $quiz = Quiz::find($id);
       $sub_questions = Quiz::join('sub_question_answer', 'quizzes.id', '=', 'sub_question_answer.parent_question_id')         
            ->select('sub_question_answer.*')
            ->where('quizzes.sub_question','=','No')
            ->orderBy('quizzes.order','ASC')
            ->get();

 $quiz['sub_questions'] = $sub_questions;
 foreach($sub_questions as $key=>$value){
       $subquestion  = Quiz::select('question,order')->find($value['question_id']);
       $quiz['sub_questions'][$key]['order']= $subquestion['order'];
       $quiz['sub_questions'][$key]['sub_que']= $subquestion['question'];
 }
           

  
        if (is_null($quiz)) {
            return $this->sendError('Quiz not found.');
        }
   
        return $this->sendResponse($quiz, 'Quiz retrieved successfully.');
    }

    public function getQuizCategoryList(Request $request){
        $quizCategory = QuizCategory::where('status','1')->get();
        return $this->sendResponse($quizCategory,'Quiz Category Retrived successfully');
    }
}