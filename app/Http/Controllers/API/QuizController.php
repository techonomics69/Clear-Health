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
        $quiz['sub_questions'] = Quiz::join('sub_question_answer', 'quizzes.id', '=', 'sub_question_answer.parent_question_id')         
            ->select('sub_question_answer.*')
            ->where('quizzes.sub_question','=','No')
            ->orderBy('sub_question_answer.id','ASC')
            ->get()->toArray();

            /*echo "<pre>";
            print_r($data);
            echo "<pre>";
            exit();*/

  
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