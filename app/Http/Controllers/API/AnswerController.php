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


    public function getAnswer($id)
    {
        try{
            $answer = Answers::where('user_id', $id)->get();
            return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }
    }

    public function answer(Request $request)      
    {
        $data = $request->all();
    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'case_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
        $answer = Answers::where('user_id', $data['user_id'])->where('case_id', $data['case_id'])->first();
        $query = 'insert';
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
