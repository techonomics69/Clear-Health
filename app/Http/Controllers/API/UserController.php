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
use App\Models\Cart;
use App\Models\UserPics;
//use App\Http\Controllers\API\Mail;
//use Illuminate\Mail\Mailable;
use Mail;
use File;

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
    if(isset($case_status) && $case_status->case_status == 'completed')
    {
        $complete = false;
    }

    $status = false;
    if(isset($order_status) && $order_status->user_id == $user->id)
    {
        $status = true;
    }

    $user['case_status'] = $complete;
    $user['order_status'] = $status;
    return $this->sendResponse($user,'user Retrived successfully');
}

public function updateVerifiedByVouch(Request $request){
    try{

        //$input = $request->all();

        $user_id = $request['user_id'];
        $case_id = $request['case_id'];
        $order_id = $request['order_id'];

        $data = User::where('id',$user_id)->update(['verified_by_vouch' => $request['verified_by_vouch']]);

        //$user = User::find($id);

         $orderdata = checkout::where('checkout.order_id',$order_id)->where('checkout.case_id',$case_id)->where('checkout.user_id',$user_id)->first();

        //code gor md create case
        if($orderdata['medication_type'] == 1){

            //call create patient api
                $patient_id = create_patient($user_id,$case_id,$order_id);
            //end of code create patient api


            if($patient_id != '' && $data == 1){

               $cart_ids = explode(',', $orderdata['cart_id']);

               $pharmacy_data  =  Cart::select('pharmacy_pickup')->where('user_id',$user_id)->whereIn('id',$cart_ids)->where('order_type', '!=', 'AddOn')->first();

               $preferred_pharmacy_id = $pharmacy_data['pharmacy_pickup'];

               $response = CreateCase($user_id,$case_id,$preferred_pharmacy_id,$patient_id);

               $response = json_decode($response);

               if(!empty($response)){

                $md_response = $response;
               
                 return $this->sendResponse($md_response, 'User Status Updated Successfully');
                }
            }else{
                 return $this->sendResponse(array(), 'something went wrong!');
            }
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

public function addUserPic(Request $request)
{

    $user_id = $request['user_id'];
    $case_id = $request['case_id'];
    $user_left_pic = $request->file('left_pic');
    $user_right_pic = $request->file('right_pic');
    $user_straight_pic = $request->file('straight_pic');

    
    $destinationPath = public_path('/images/Users');

    if(!empty($user_left_pic)){
      $left_pic =  $user_left_pic->getClientOriginalName();
      $file_name_left_pic =  time().'-'.$left_pic;
      
      if (!file_exists(public_path('/images/Users'))) {
        File::makeDirectory(public_path('/images/Users'),0777,true,true);
      }
      
      $user_left_pic->move($destinationPath, $file_name_left_pic);

      chmod($destinationPath."/".$file_name_left_pic, 0777);

      //$left_pic_file_path = 'public/images/Users' .$left_pic;
  
    }else{
        $file_name_left_pic = NULL;
    }

    if(!empty($user_straight_pic)){
      $straight_pic =  $user_straight_pic->getClientOriginalName();
      $file_name_straight_pic =  time().'-'.$straight_pic;
      
      if (!file_exists(public_path('/images/Users'))) {
        File::makeDirectory(public_path('/images/Users'),0777,true,true);
      }
      //$straight_pic_destinationPath = public_path('/images/Users');
      $user_straight_pic->move($destinationPath, $file_name_straight_pic);

      chmod($destinationPath."/".$file_name_straight_pic, 0777);

      //$straight_pic_file_path = 'public/images/Users' .$straight_pic;
  
    }else{
        $file_name_straight_pic = NULL; 
    }

    if(!empty($user_right_pic)){
      $right_pic =  $user_left_pic->getClientOriginalName();
      $file_name_right_pic =  time().'-'.$right_pic;
      
      if (!file_exists(public_path('/images/Users'))) {
        File::makeDirectory(public_path('/images/Users'),0777,true,true);
      }
      $destinationPath = public_path('/images/Users');
      $user_right_pic->move($destinationPath, $file_name_right_pic);

      chmod($destinationPath."/".$file_name_right_pic, 0777);

      //$right_pic_file_path = 'public/images/Userss' .$right_pic;
  
    }else{
      $file_name_right_pic = NULL;  
    }


$parent = UserPics::create(array(
    'user_id'=>$user_id,
    'case_id'=>$case_id,
    'left_pic'=>$file_name_left_pic,
    'straight_pic'=>$file_name_straight_pic,
    'right_pic'=>$file_name_right_pic,
));

return $this->sendResponse($parent, 'User picture saved successfully.');

}

public function getUserPic(Request $request)
{
  $user_id = $request['user_id'];
  $case_id = $request['case_id'];
  $userpic=UserPics::where('user_id',$request['user_id'])->where('case_id',$request['case_id'])->get();
  return $this->sendResponse($userpic, 'User picture saved successfully.');

}

}

