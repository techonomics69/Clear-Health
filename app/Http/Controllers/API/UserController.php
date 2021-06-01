<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\CaseManagement;
use App\Models\Checkout;
use App\Models\Parentdetail;
use Validator;
use Exception;
use Spatie\Permission\Models\Role;
//use App\Http\Controllers\API\Mail;
//use Illuminate\Mail\Mailable;
use Mail;

class UserController extends BaseController
{
    public function update_user(Request $request, $id){
        try{
            $user = User::find($id);
            $validator = Validator::make($request->all(), [     
               // 'email' => 'required|unique:users,email,'.$user->id,
                //'zipcode' => 'numeric|digits:6'
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }

            $input = $request->all();
            
            $user->update($input);
            
            return $this->sendResponse(array(), 'User Updated successfully');
        }catch(\Exception $ex){
           return $this->sendError('Server error',array($ex->getMessage()));
       }
   }

   public function userlist(){
    try{
        $user = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Customer');
            }
        )->get();
        return $this->sendResponse($user, 'Users retrieved successfully.');
    }catch(\Exception $ex){
        return $this->sendError('Server error', array($ex->getMessage()));
    }
}

public function sendmail(Request $request)
{
    $data = $request->all();
    if(empty($data['user_id'])):
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

    endif;  
endif;  
try{
    $userEmail = $request['user_mail'];


    $details = [
       'body' => 'Thank you for showing interest in ClearHealth by Nefaire. We will get back to you soon.'
   ];

   \Mail::to($userEmail)->cc('mchang@nefaire.com')->send(new \App\Mail\NotifyMail($details));
   return $this->sendResponse($data, 'Thank you for your interest in clearhealth');
}catch(\Exception $ex){
    return $this->sendError('Server error', array($ex->getMessage()));
}
}

public function addParentdetails(Request $request)
{
    $data = $request->all();
    if(empty($data['user_id'])):
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

    endif;  
endif; 

try{
   $validator = Validator::make($data, [
     'user_id'=> 'required',
     'first_name' => 'required',
     'last_name' => 'required', 
     'phone' => 'required|digits:10',
     'email' => 'required|email',  
 ]);
   if($validator->fails()){
    return $this->sendError('Validation Error.', $validator->errors()->all());       
}

$input = $request->all();
$parent = Parentdetail::create(array(
    'user_id'=>$request->user_id,
    'first_name'=>$request->first_name,
    'last_name'=>$request->last_name,
    'phone'=>$request->phone,
    'email'=>$request->email,
));
return $this->sendResponse($parent, 'Parent details saved successfully.');
}catch(\Exception $ex){
    return $this->sendError('Server error', array($ex->getMessage()));
}


}

public function getParentdetails(Request $request){
    $parentdata = Parentdetail::where('user_id',$request['user_id'])->first();
    return $this->sendResponse($parentdata,'Parentdetail Retrived successfully');
}


public function show($id)
{
    $user = User::find($id);
                //$success['user_id'] =  $user->id;
    $case_status =  CaseManagement::where("user_id", $user->id)->OrderBy("id" , "DESC")->first();
    $order_status = Checkout::where("user_id",$user->id)->first();

    $complete = true;
    if($case_status->case_status == 'completed')
    {
        $complete = false;
    }

    $status = false;
    if($order_status->user_id == $user->id)
    {
        $status = true;
    }

    $user[0]['case_status'] = $complete;
    $user['order_status'] = $status;
    return $this->sendResponse($user,'user Retrived successfully');
}

public function updateVerifiedByVouch(Request $request, $id){
    try{
        $input = $request->all();

        $data = User::whereId($id)->update($input);

        $user = User::find($id);

        if($data == 1){
            return $this->sendResponse($user, 'User Status Updated Successfully');
        }else{

          return $this->sendResponse($user, 'Something went wrong!');  
      }

  }catch(\Exception $ex){
   return $this->sendError('Server error',array($ex->getMessage()));
}
}

public function getVouchedDetails(Request $request, $id){
    try{
        $input = $request->all();

        $user = User::find($id);


        $vouched_details = json_decode($user['vouched_details']);



        if(!empty($user)){
            return $this->sendResponse($vouched_details, 'Users vouched details retrived successfully');
        }else{

          return $this->sendResponse($user, 'NO data found!');  
      }

  }catch(\Exception $ex){
   return $this->sendError('Server error',array($ex->getMessage()));
}
}
}

