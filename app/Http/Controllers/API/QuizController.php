<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\Birthcontrolanswer;
use Validator;
use Exception;

   
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

    public function getBirthControlQuestions(Request $request){
        
        $quiz = Quiz::where('status','1')->where('category_id',14);
        if(isset($request->mainq)){
            if(!empty($request->mainq)){
                $request['mainq'] = rtrim($request->main,",");
                $ids = explode(",",$request->mainq);
                $quiz = $quiz->whereIn('id',$request->mainq);
            }
        }   
        $quiz = $quiz->get();
        return $this->sendResponse($quiz, 'Quiz retrieved successfully.');
    }

    public function StoreBirthControlAnswer(Request $request){
        try{
            // $validator = Validator::make($data, [
            //     'user_id' => 'required',
            //     'case_id' => 'required',
            //     'answer'  => 'required',
            //     'last_stpe' => 'required'
            // ]);
            // if($validator->fails()){
            //     return $this->sendError('Validation Error.', $validator->errors()->all());       
            // }
            unset($request->_method);
            unset($request->_token);
            $data = $request->all();
            if(isset($data['id'])){    
                $getFirst = Birthcontrolanswer::select('answer')->where('id',$data['id'])->get();
                if(count($getFirst)>0){
                    $que = json_decode($getFirst[0]->answer);
                    $arr1 = array();
                    if(count($que) > 0){
                        foreach($que as $k => $v){
                            array_push($arr1, $que[$k]);
                        }
                    }
                    array_push($arr1, $data['answer']);
                    $data['answer'] = $arr1;
                    $update = Birthcontrolanswer::where('id',$data['id'])->update($data);
                    return $this->sendResponse(array(), 'Data Updated Successfully');
                }else{
                    return $this->sendError('No Records found');
                }
            }else{
                $insert = Birthcontrolanswer::create($data);
                return $this->sendResponse(array(), 'Data Saved Successfully');
            }
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
    }
}