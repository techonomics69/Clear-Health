<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\Mdpatient;
use Validator;
use Exception;
use App\Models\User;
use App\Models\CaseHistory;
use App\Models\FollowUp;
use App\Models\Notifications;
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


  public function addFollowUpData(Request $request)
  {

    $data = $request->all();

    try {
      $validator = Validator::make($data, [
        'user_id' => 'required',
        'case_id' => 'required',
        'answer' => 'required',
      ]);
      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors()->all());
      }
      $followUpCount = FollowUp::where('user_id', $data['user_id'])
        ->where('case_id', $data['case_id'])
        ->where('follow_up_status', 'completed')
        ->count();
      $data['follow_up_no'] = $followUpCount + 1;
      $followUpAns = FollowUp::where('user_id', $data['user_id'])
        ->where('case_id', $data['case_id'])
        // ->where('follow_up_no', $data['follow_up_no'])
        ->where('follow_up_status', '<>', 'completed')
        ->first();
      if (!empty($followUpAns)) :
        $followUpAns = $followUpAns->update($data);
      else :
        $followUpAns = FollowUp::create($data);
      endif;

      return $this->sendResponse($followUpAns, 'Follow Up Answer Submitted Successfully');
    } catch (\Exception $ex) {
      return $this->sendError('Server error', array($ex->getMessage()));
    }
  }

  public function getFollowUpAnswer(Request $request)
  {
    $data = $request->all();
    try {
      $answer = FollowUp::where('user_id', $data['user_id'])
        ->where('case_id', $data['case_id'])
        ->where('follow_up_status', '<>', 'completed')
        ->first();

      return $this->sendResponse($answer, 'Follow Up Answer Retrieved Successfully.');
    } catch (\Exception $ex) {
      return $this->sendError('Server error', array($ex->getMessage()));
    }
  }



  public function updateFollowUpData(Request $request)
  {

    $data = $request->all();

    $user_id = $request['user_id'];
    $case_id = $request['case_id'];
    $md_case_id = $request['md_case_id'];

    try {
      $validator = Validator::make($data, [
        'user_id' => 'required',
        'case_id' => 'required',
        //'answer' => 'required',
      ]);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors()->all());
      }

      $destinationPath = public_path('/images/Users');
      $userGender = User::find($user_id)->gender;
      $followUpAns = FollowUp::where('user_id', $data['user_id'])
        ->where('case_id', $data['case_id'])
        ->where('follow_up_status', '<>', 'completed')
        ->first();
      if ($request['left_face'] != '') {
        $left_face = $request['left_face'];
        $left_face_file_name =  $user_id . '_left_face_' . time() . '.jpeg';
        $this->createImage($left_face, $left_face_file_name);
        $data['left_face'] = $left_face_file_name;
      }

      if ($request['right_face'] != '') {
        $right_face = $request['right_face'];
        $right_face_file_name =  $user_id . '_right_face_' . time() . '.jpeg';
        $this->createImage($right_face, $right_face_file_name);
        $data['right_face'] = $right_face_file_name;
      }


      if ($request['center_face'] != '') {
        $center_face = $request['center_face'];
        $center_face_file_name =  $user_id . '_center_face_' . time() . '.jpeg';
        $this->createImage($center_face, $center_face_file_name);
        $data['center_face'] = $center_face_file_name;
      }

      if ($request['back_photo'] != '') {
        $back_photo = $request['back_photo'];
        $back_photo_file_name =  $user_id . 'back_photo' . time() . '.jpeg';
        $this->createImage($back_photo, $back_photo_file_name);
        $data['back_photo'] = $back_photo_file_name;
      }

      if ($request['chest_photo'] != '') {
        $chest_photo = $request['chest_photo'];
        $chest_photo_file_name =  $user_id . 'chest_photo' . time() . '.jpeg';
        $this->createImage($chest_photo, $chest_photo_file_name);
        $data['chest_photo'] = $chest_photo_file_name;
        if ($userGender == 'male') :
          $data['follow_up_status'] = 'completed';
          $caseManage = CaseManagement::find($case_id);
          if ($caseManage) :
            $case_data['follow_up'] = $followUpAns['follow_up_no'];
            $caseSave = $caseManage->update($case_data);
            $input_data['case_status'] = 'prior_auth';
            $caseHistory = CaseHistory::where('case_id', $request['case_id'])->update($input_data);

            $noti_input_data = array();
            $noti_input_data['user_id'] = $user_id;
            $noti_input_data['case_id'] = $case_id;
            $noti_input_data['md_case_id'] = $md_case_id;
            $noti_input_data['noti_message'] = getNotificationMessageFromKey('follow_up_case_submitted');
            $noti_input_data['for_month'] = $followUpAns['follow_up_no']+1;

            $noti_data = Notifications::create($noti_input_data);
          endif;
        endif;
      }

      if ($request->file('pregnancy_test') != '') {
        $pregnancy_test = $request->file('pregnancy_test');
        if (!empty($pregnancy_test)) {
          $pregnancy_test_file =  $pregnancy_test->getClientOriginalName();
          $pregnancy_test_file_name =  time() . '-' . $pregnancy_test_file;

          if (!file_exists(public_path('/images/Users'))) {
            File::makeDirectory(public_path('/images/Users'), 0777, true, true);
          }

          $pregnancy_test->move($destinationPath, $pregnancy_test_file_name);

          chmod($destinationPath . "/" . $pregnancy_test_file_name, 0777);

          $data['pregnancy_test'] = $pregnancy_test_file_name;
          if ($userGender == 'female') :
            $data['follow_up_status'] = 'completed';
            $caseManage = CaseManagement::find($case_id);
            if ($caseManage) :
              // echo '<pre>';
              // print_r($followUpAns);
              // die;
              $case_data['follow_up'] = $followUpAns['follow_up_no'];
              $caseSave = $caseManage->update($case_data);
              $input_data['case_status'] = 'verify_pregnancy';
              $caseHistory = CaseHistory:: where('case_id', $request['case_id'])->update($input_data);

              $noti_input_data = array();
              $noti_input_data['user_id'] = $user_id;
              $noti_input_data['case_id'] = $case_id;
              $noti_input_data['md_case_id'] = $md_case_id;
              $noti_input_data['noti_message'] = getNotificationMessageFromKey('follow_up_case_submitted');
              $noti_input_data['for_month'] = $followUpAns['follow_up_no']+1;

              $noti_data = Notifications::create($noti_input_data);
            endif;
          endif;
        }
      }

      if (!empty($followUpAns)) :
        $followUpAns = $followUpAns->update($data);
      endif;

      return $this->sendResponse($followUpAns, 'Follow Up Data Updated Successfully');
    } catch (\Exception $ex) {
      return $this->sendError('Server error', array($ex->getMessage()));
    }
  }



  public function createImage($img, $file_name)
  {

    $data = $img;

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    $destinationPath = public_path('/images/Users/' . $file_name . '');

    if (!file_exists(public_path('/images/Users'))) {
      File::makeDirectory(public_path('/images/Users'), 0777, true, true);
    }

    file_put_contents($destinationPath, $data) or print_r(error_get_last());

    chmod($destinationPath, 0777);
  }

  public function createFollowUpMDCase(request $request){
      $user_id = $request['user_id'];
      $case_id = $request['case_id'];
      $preferred_pharmacy_id = getPickupPharmacy($user_id,$case_id);
      $response = CreateFollowUPCase($user_id,$case_id,$preferred_pharmacy_id,$order_id);
  }
}
