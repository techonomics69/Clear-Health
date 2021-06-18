<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\Mdpatient;
use Validator;
use Exception;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Parentdetail;
use App\Models\Mdcases;
use App\Models\Mdmanagement;
use App\Models\CaseFiles;
use App\Models\MdMessages;
use App\Models\MdMessageFiles;
use App\Models\Answers;
use App\Models\MessageFiles;
use App\Models\Messages;
use App\Models\FollowUp;
use File;

class FollowupController extends BaseController
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
    

  public function addFollowUpData(Request $request){

    $data = $request->all();

    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'case_id' => 'required',
            'answer' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
       
       $followUpAns = FollowUp::create($data);
      
       return $this->sendResponse($followUpAns, 'Follow Up Answer Submitted Successfully');

   }catch(\Exception $ex){
      return $this->sendError('Server error',array($ex->getMessage()));
   }


  }

   public function getFollowUpAnswer(Request $request)
    {
        try{
           $answer = FollowUp::where('user_id', $request['user_id'])->where('case_id', $request['case_id'])->first();
            return $this->sendResponse($answer, 'Follow Up Answer Retrieved Successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function updateFieldInCaseManagement(Request $request){

      $user_id = $request['user_id'];
      $case_id = $request['case_id'];
      $md_case_id = $request['md_case_id'];

      $update_data = array();

      if(isset($request['abstinence_form'])){
        $update_data['abstinence_form'] =  $abstinence_form = $request['abstinence_form'];

      }

      if(isset($request['sign_ipledge_consent'])){
        $update_data['sign_ipledge_consent'] =  $sign_ipledge_consent = $request['sign_ipledge_consent'];
      }
      

      $data  =  CaseManagement::where([['user_id',$user_id], ['id', $case_id],['md_case_id', $md_case_id]])->update($update_data);

      return $this->sendResponse($data,'Field Updated Successfully.');


    }

    public function updateFollowUpData(Request $request){

    $data = $request->all();

    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'case_id' => 'required',
            //'answer' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }

        $followUpAns = FollowUp::where('user_id', $data['user_id'])->where('case_id', $data['case_id'])->->where('follow_up_status','!=','completed')->first();
        if(!empty($followUpAns)):
           $followUpAns = $followUpAns->update($data);
       endif;

       return $this->sendResponse($followUpAns, 'Follow Up Answer Submitted Successfully');
   }catch(\Exception $ex){
      return $this->sendError('Server error',array($ex->getMessage()));
   }


  }


}