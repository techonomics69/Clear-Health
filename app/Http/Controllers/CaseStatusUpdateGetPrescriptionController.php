<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CaseManagement;
use App\Models\QuizCategory;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\Answers;
use App\Models\Checkoutaddress;
use App\Models\Checkout;
use App\Models\Cart;
use App\Models\Product;
use Session;


class CaseStatusUpdateGetPrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $data = CaseManagement::all();

      $r = get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      foreach($data as $key=>$value){

        $user_id = $value['user_id'];
        $case_id = $value['md_case_id'];
        $system_case_id = $value['id'];

        $recommended_product = $value['recommended_product'];

        $system_status = 'Telehealth Evaluation Requested';

        $case_type_detail = getCaseType($user_id,$case_id);

        if($value['md_case_status']!= 'completed'){

          $userQueAns = getQuestionAnswerFromUserid($user_id,$system_case_id);

          if(!empty($userQueAns)){
            foreach ($userQueAns as $key => $value) {
             $question = $value->question;
             if($question == "What was your gender assigned at birth?"){
              if(isset($value->answer) && $value->answer!=''){

                $gender =  $value->answer;
              }
            }
          }

        }

        if($case_id != '' || $case_id != NULL){

         $curl = curl_init();

         curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
          ),
        ));

         $response = curl_exec($curl);

         $MdCaseStatus = json_decode($response);

         curl_close($curl);

        if(!empty($MdCaseStatus)){

          $md_case_status = $MdCaseStatus->status;

          if(!empty($MdCaseStatus->case_assignment)){
            $md_status = 'assigned'; 
          }else{
            $md_status = NULL;
          }


          if($gender == "Female" && $recommended_product == 'Accutane'){

                /*
                1.   Telehealth Evaluation Requested -> sent to MD Integrations  (case status MD side = pending )
                2.   Awaiting Live Consultation -> MD assigned, call not initiated ( MD guys will call ping our API using webhook and we will get notified that MD has been assigned)
                3.   Awaiting Follow-Up -> (case status received as support from MD)
                4.   Awaiting Prescription Approval(Follow up ->send case to md )
                5.   Prescription Approved -> (prescription confirmed by dosespot/script is written i.e. case status received from MD = Dosespot confirmed)
                6.   Awaiting Action Items
                */
                if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'pending'){

                  $system_status = 'Awaiting Live Consultation';
                }

                if($md_case_status == 'support'){

                  $system_status = 'Awaiting Follow-Up';
                }

                if($md_case_status =='support'){

                  $system_status = ' Awaiting Prescription Approval';
                }

                if( $md_case_status == 'dosespot confirmed'){

                  $system_status = 'Prescription Approved';
                }
                

                if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'dosespot confirmed'){
                  $system_status = 'Awaiting Action Items';
                }

          }else if($gender == "Male" && $recommended_product == 'Accutane'){
                /*
                  Initial Accutane Male Flow:
            
                  1. Telehealth Visit Requested/ Awaiting Clinician assigned - after vouched verification is done.
                  2. MD Assigned
                  3. Awaiting Prescription Approval
                  4. Prescription Approved
                */

         }else{
                /*
                Topical Male & Female:

                1. Telehealth Evaluation Requested
                2. Prescription Approved/Denied
                */
              }

              $case_management  =  CaseManagement::where('id',$case_id)->where('user_id',$user_id)->update(['md_case_status' => $MdCaseStatus->status,'md_status' => $md_status,'system_status'=> $system_status ]);

               //code for update md details

              $inputmd_data['status'] = 1;
              $inputmd_data['image'] = "";
              $inputmd_data['language_id'] = "";
              $inputmd_data['md_id'] = $MdCaseStatus->case_assignment->clinician->clinician_id;
              $inputmd_data['name'] = $MdCaseStatus->case_assignment->clinician->full_name;
              $inputmd_data['reason'] = $MdCaseStatus->case_assignment->reason;;
              $inputmd_data['case_assignment_id'] = $MdCaseStatus->case_assignment->case_assignment_id;

              $mdmanagement_data = Mdmanagement::where('case_id', $case_id)->first();

              if(!empty($mdmanagement_data)){

                $mdmanagement_data->update($inputmd_data);

              }else{
                $md_case_data = Mdmanagement::create($inputmd_data);
              }

        }
            //md status completed

          }
        }

      }

      //end code
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
        //
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







    


  }
