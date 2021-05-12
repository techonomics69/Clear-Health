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
        $quiz = Quiz::where('status','1')->OrderBy('order','ASC')->get();
        
        return $this->sendResponse($quiz, 'Quiz retrieved successfully.');
    }

    public function show($id)
    {
        $quiz = Quiz::find($id);
  
        if (is_null($quiz)) {
            return $this->sendError('Quiz not found.');
        }
   
        return $this->sendResponse($quiz, 'Quiz retrieved successfully.');
    }

    public function getQuizCategoryList(Request $request){
        $quizCategory = QuizCategory::where('status','1')->get();
        return $this->sendResponse($quizCategory,'Quiz Category Retrived successfully');
    }

    public function getQuizByOrderAndCategory(Request $request){
        $quiz = Quiz::where('order', $request->order)->where('category_id', $request->category_id)->first();
        return $this->sendResponse($quiz,'Question Retrived successfully');
    }

    public function getQuestionListOfGeneral(Request $request){
        $quiz = Quiz::where('status','1')->where('category_id', 7)->OrderBy('order','ASC')->get();
        
        return $this->sendResponse($quiz, 'General Question retrieved successfully.');
    }
}