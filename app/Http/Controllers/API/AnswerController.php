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
            $answer = Answers::where('user_id', $request->user_id)->where('case_id', $request->case_id)->get();
            if(!empty($answer)){
                 return $this->sendResponse($answer, 'Answer retrieved successfully.');
            }else{
                return $this->sendResponse($answer =array(), 'No Data Found.');
            }
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function answer(Request $request)      
    {
        $data = $request->all();
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();
        endif; 

    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'case_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
        $answer = Answers::create($data);
        return $this->sendResponse(array(), 'Answer Added Successfully');
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
