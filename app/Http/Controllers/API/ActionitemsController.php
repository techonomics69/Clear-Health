<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\IpledgeAgreement;
use Validator;
use Exception;

class ActionitemsController extends BaseController
{
    public function index()
    {
 
    }


    public function getIpledgeAgreement(Request $request)
    {
        try{
            $answer = Answers::where('user_id', $request->user_id)->where('case_id', $request->case_id)->where('category_id', $request->category_id)->first();
          
                 return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

     public function addIpledgeAgreement(Request $request)      
    {
        $data = $request->all();
   
        try{
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'case_id' => 'required',
                'md_case_id' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            $agreement = IpledgeAgreement::where('user_id', $data['user_id'])->where('case_id', $data['case_id'])->where('md_case_id', $data['md_case_id'])->first();
            if(isset($agreement)){
                $agreementUpdate = IpledgeAgreement::where('id',$agreement->id)->update($data);
                return $this->sendResponse($data, 'Form Data Updated Successfully');
            }else{
                $agreementInsert = IpledgeAgreement::create($data);
                return $this->sendResponse($agreementInsert, 'Form Data Added Successfully');
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
