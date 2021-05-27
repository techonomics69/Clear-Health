<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Answers;
use Validator;
use Exception;

class AnswerController extends BaseController
{
    public function index()
    {
 
    }


    public function getAnswer(Request $request)
    {
        try{
            $answer = Answers::where('user_id', $request->user_id)->where('case_id', $request->case_id)->where('category_id', $request->category_id)->first();
          
                 return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

     public function answer(Request $request)      
    {
        $data = $request->all();

        print_r($data);
       
        try{
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'case_id' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            $answer = Answers::where('user_id', $data['user_id'])->where('case_id', $data['case_id'])->where('category_id', $data['category_id'])->first();
            if(isset($answer)){
                $answerUpdate = Answers::where('id',$answer->id)->update($data);
                return $this->sendResponse(array(), 'Answer Updated Successfully');
            }else{
                $answerInsert = Answers::create($data);
                return $this->sendResponse(array(), 'Answer Added Successfully');
            }
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
    }


public function create()
{

}


public function store(Request $request)
{

}


public function show($id)
{

}

public function edit($id)
{

}


public function update(Request $request, $id)
{

}

public function destroy($id)
{

}
}
