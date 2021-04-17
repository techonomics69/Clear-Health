<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\QuizAnswer;
use Validator;
use Exception;
use Lcobucci\JWT\Parser;
use App\Models\CaseManagement;

class QuizAnswerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();
            $data['case_id'] = CaseManagement::where('user_id', $data['user_id'])->OrderBy('id','desc')->first()->id;

        endif;       
        try{
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'question_id' => 'required',
                'answer' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            $answer = QuizAnswer::where('user_id', $data['user_id'])->where('question_id', $data['question_id'])->where('case_id', $data['case_id'])->first();
            if(!empty($answer)):
            	$answer->update($data);
            else:
            	$quizAns = QuizAnswer::create($data);
            endif;
            
            return $this->sendResponse(array(), 'Answer submitted successfully');
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAnswerByUser($id)
    {
        try{
            $answer = QuizAnswer::where('user_id', $id)->get();
            return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function getAnswerByQuestion($id)
    {
        try{
            $answer = QuizAnswer::where('question_id', $id)->get();
            return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function getAnswerByUserQuestionCaseID(Request $request)
    {
        try{
            $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('case_id', $request->case_id)->first();
            if(!empty($answer)){
                 return $this->sendResponse($answer, 'Answer retrieved successfully.');
            }else{
                return $this->sendResponse($answer =array(), 'No Data Found.');
            }
           
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }
}
