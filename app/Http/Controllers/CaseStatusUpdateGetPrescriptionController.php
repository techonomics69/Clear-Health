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
use App\Models\Mdmanagement;
use App\Models\CasePrescriptions;
use App\Models\PrescriptionCompound;
use App\Models\PrescriptionMedication;
use App\Models\Mdpatient;
use App\Models\CurexaOrder;
use App\Models\Mdcases;
use App\Models\CaseHistory;

use App\Models\Triggers;
use App\Models\Notifications;
use App\Helper\shipStationHelper;

use Session;
use Carbon\Carbon;


class CaseStatusUpdateGetPrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //$data = CaseManagement::join('md_cases', 'md_cases.system_case_id', '=', 'case_managements.id')->select('case_managements.*')->get()->toArray();

      $data = Mdcases::join('case_managements','case_managements.md_case_id', '=','md_cases.case_id' )->join('users','users.id','=','md_cases.user_id')->select('case_managements.*','users.*')->get()->toArray();

      $r = get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      $ship_orderIds = array();

      $follow_up_data = array();

      foreach($data as $key=>$value){

       $follow_up_data = Mdcases::join('follow_up','follow_up.md_case_id', '=','md_cases.case_id' )->select('follow_up.follow_up_no')->where('md_cases.case_id',$value['md_case_id'])->first();

       $user_id = $value['user_id'];
       $case_id = $value['md_case_id'];
       $system_case_id = $value['id'];
       $user_email =  $value['email'];
       $user_phone = $value['mobile'];

       $gender = $value['gender'];

      $order_data = Checkout::where([['user_id', $user_id],['case_id', $system_case_id],['md_case_id', $case_id]])->first();

        
        //$ShiStation = shipStationHelper::getOrderData($order_data['shipstation_order_id']);

         


     /*  $cart_ids = explode(',', $order_data['cart_id']);
       $pharmacy_data  =  Cart::select('pharmacy_pickup')->where('user_id',$user_id)->whereIn('id',$cart_ids)->where('order_type', '!=', 'AddOn')->first();
       $preferred_pharmacy_id = $pharmacy_data['pharmacy_pickup'];*/

       $preferred_pharmacy_id = getPickupPharmacy($user_id,$system_case_id,$case_id);

       $curexadata = CurexaOrder::where('order_id',$order_data['order_id'])->first();

       $dispached_date = new Carbon($curexadata['dispached_date']);
       $now = Carbon::now();
       $difference = $dispached_date->diffInDays($now);


       $triggers = Triggers::where([['user_id', $user_id],['case_id', $system_case_id],['md_case_id', $case_id],['name','pickup_medication_notification'],['month',2]])->first();

       $pickup_medication_notification_date = new Carbon($triggers['updated_at']);
       $now = Carbon::now();
       $pickup_medication_difference = $pickup_medication_notification_date->diffInDays($now);

       //code for pickup_notification month wise

       $follow_up_no = $follow_up_data['follow_up_no'];
       $month_no = $follow_up_data['follow_up_no']+1;

       

       $month_triggers = Triggers::where([['user_id', $user_id],['case_id',$system_case_id],['md_case_id', $case_id],['name','pickup_medication_notification'],['month',$month_no]])->first();

       $month_pickup_medi_noti_date = new Carbon($month_triggers['updated_at']);
     
       $now = Carbon::now();
       $today_date = $now->toDateTimeString();

        $notification_date = $month_pickup_medi_noti_date->addDays(10);

        $sent_notification_date =  $notification_date->toDateTimeString();

        $today_date = Carbon::createFromFormat('Y-m-d H:i:s',$today_date);
        $sent_notification_date = Carbon::createFromFormat('Y-m-d H:i:s', $sent_notification_date);

       //end of code for pickup_notification month wise

        $product_type = $value['product_type'];

        /*$gender = 'female';//0;
        $product_type = "Accutane";*/

        $system_status = 'Telehealth Evaluation Requested';


        if($value['md_case_status']!= 'completed'){

          $userQueAns = getQuestionAnswerFromUserid($user_id,$system_case_id);

          /*if(!empty($userQueAns)){
            foreach ($userQueAns as $k => $val) {
             $question = $val->question;
             if($question == "What was your gender assigned at birth?"){
               if(isset($val->answer) && $val->answer!=''){

                $gender =  $val->answer;
              }
            }
          }
        }*/

        //$gender =  $gender = $value['gender'];

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

            $md_case_status = $MdCaseStatus->case_status->name;//enable this aafter testing is done

          //$md_case_status = 'completed'; //remove this

          if(!empty($MdCaseStatus->case_assignment)){
            $md_status = 'assigned'; 
          }else{
            $md_status = NULL;
          }

          $case_type = getCaseType($user_id,$case_id,$system_case_id);

          $get_support_reason = Mdcases::select('case_status_reason')->where('case_id',$case_id)->first();


          $support_reason = $get_support_reason['case_status_reason'];


          if($MdCaseStatus->case_status->reason != null ){

            $support_reason = $MdCaseStatus->case_status->reason;

            $input_data['case_status'] = 'generate_ipledge';
            $caseHistory = CaseHistory::where('case_id', $system_case_id)->update($input_data);

          }
          //$support_reason = "had call with MD";//remove after testing enable this to test welcome email

          $prescriptiondata = CasePrescriptions::where([['user_id',$user_id],['case_id',$case_id],['system_case_id',$system_case_id]])->first();


          //SMS Check-ins    

          if($today_date->eq($sent_notification_date) && $product_type == 'Accutane' && ($gender == "female"||$gender == "male")){
            $medicin_pickup_notification = array();

                $user = array($user_phone);
                //$user = array('+917874257069');
                $medicin_pickup_notification['users'] = $user;
                $medicin_pickup_notification['body'] = "prescription sent";
                $medicin_pickup_notification_sent = sendsms($medicin_pickup_notification); 
        } 
 

          //end of SMS Check-ins    

          //if($gender == "Female" && $product_type == 'Accutane' && $case_type = 'new'){
          if($gender == "female" && $product_type == 'Accutane'){ 

              //send welcome email 

            if( $support_reason != NULL && empty($follow_up_data)){

              $email_data = array();

              $email_data['email'] = 'itqatester12@gmail.com';//$user_email;
              $email_data['title'] = 'helloclearhealth.com';
              $email_data['body'] = "Welcome Email when prescription is approved detailing Accutane instructions + prompt them to sign forms";
              $email_data['template'] = 'emails.mySendMail';

              $email_sent = sendEmail($email_data);

            }


              //end of welcome email  

              //welcome sms
                $smsdata = array();

                //$user = array($user_phone);
                $user = array('+917874257069');
                $smsdata['users'] = $user;
                $smsdata['body'] = "Welcome SMS to Clear Health when treatment is approved detailing Accutane instructions + prompt them to sign forms";
                $sms_sent = sendsms($smsdata);

              //end of welcome message                                                      

                /*
                1.   Telehealth Evaluation Requested -> sent to MD Integrations  (case status MD side = created )
                2.   Awaiting Live Consultation -> MD assigned, call not initiated (case status MD side = assigned and case_status_reason != null ) ( MD guys will call ping our API using webhook and we will get notified that MD has been assigned)
                3.   Awaiting Follow-Up -> (case status MD side = support and case_status_reason != null  and prescription is not stored yet in our db )(case status received as support from MD)
                4.   Awaiting Prescription Approval(case status MD side = processing and dosespot_confirmation_status=pending)(Follow up ->send case to md )
                5.   Prescription Approved -> (case status MD side = processing and dosespot_confirmation_status=pharmacy_verified)(prescription confirmed by dosespot/script is written i.e. case status received from MD = Dosespot confirmed)
                6.   Awaiting Action Items
                */
                //if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'pending' && $case_type = 'new'){
                if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'assigned' ){

                  $system_status = 'Awaiting Live Consultation';
                }

                //if($md_case_status == 'support' && $case_type = 'new' && ($support_reason != '' || $support_reason != NULL)){
                if($md_case_status == 'completed' && ($support_reason != '' || $support_reason != NULL) && empty($prescriptiondata)){

                  $system_status = 'Awaiting Follow-Up';
                }

               // if($md_case_status =='support' && $case_type = 'follow_up'){ 
                if($md_case_status =='processing' && $prescriptiondata['dosespot_confirmation_status']  == 'pending'){

                  $system_status = ' Awaiting Prescription Approval';
                }

                //if($md_case_status == 'dosespot confirmed' && $case_type = 'follow_up'){
                if($md_case_status == 'completed'){


                  //if($follow_up_data['follow_up_no'] == 0){
                  if(empty($follow_up_data)){

                    if($value['abstinence_form']!= 0 && $value['sign_ipledge_consent']!= 0){

                      $system_status = 'Awaiting Action Items';  

                    }

                    //notification for action_items_due
                    if($support_reason != '' || $support_reason != NULL){
                    $action_items_due_noti = array();
                    $action_items_due_noti['user_id'] = $user_id;
                    $action_items_due_noti['case_id'] = $system_case_id;
                    $action_items_due_noti['md_case_id'] = $case_id;

                    $action_items_due_noti['noti_message'] = getNotificationMessageFromKey('action_items_due');
                    $action_items_due_noti['for_month'] = $follow_up_data['follow_up_no']+1;
                    $action_items_due_noti_data = Notifications::create($action_items_due_noti);
                    }
                    //end of notification for action_items_due

                    //notification for md_has_approved_your_treatment_wait_31_days

                    $approvnoti = array();
                    $approv_noti['user_id'] = $user_id;
                    $approv_noti['case_id'] = $system_case_id;
                    $approv_noti['md_case_id'] = $case_id;

                    $approv_noti['noti_message'] = getNotificationMessageFromKey('md_has_approved_your_treatment_wait_31_days');
                    $approv_noti['for_month'] = $follow_up_data['follow_up_no']+1;
                    $approv_noti_data = Notifications::create($approv_noti);

                    //end of notification for md_has_approved_your_treatment_wait_31_days


                 }

                 if($follow_up_data['follow_up_no'] != 0){

                  if($value['prior_auth_date'] != NULL){

                    $prior_auth_date = new Carbon($value['prior_auth_date']);

                    //$auth_date = Carbon::createFromFormat('Y-m-d H:i:s', $value['prior_auth_date']);
                    $now = Carbon::now();
                    $today_date = $now->toDateTimeString();

                    $checkdate = $prior_auth_date->addDays(7);

                    $display_till_date =  $checkdate->toDateTimeString();

                    $today_date = Carbon::createFromFormat('Y-m-d H:i:s', $today_date);
                    $display_till_date = Carbon::createFromFormat('Y-m-d H:i:s', $display_till_date);


                    if($today_date->lte($display_till_date)){
                      $system_status = 'Awaiting Action Items'; 
                    } 

                  }

                  //notification

                      //code  for md_has_approved_your_treatment
                    $approved_noti = array();
                    $approved_noti['user_id'] = $user_id;
                    $approved_noti['case_id'] = $system_case_id;
                    $approved_noti['md_case_id'] = $case_id;

                    $approved_noti['noti_message'] = getNotificationMessageFromKey('md_has_approved_your_treatment');
                    $approved_noti['for_month'] = $follow_up_data['follow_up_no']+1;
                    $approved_noti_data = Notifications::create($approved_noti);

                    //end of code for md_has_approved_your_treatment

                  //end of notification
                }

                  $system_status = 'Prescription Approved';


                  $response = $this->getPrescription($case_id);


                  if(!empty($response)){
                    //$this->save_prescription_response($response,$user_id,$case_id,$system_case_id);
                    $prescription_data = json_decode($response);

                    if($preferred_pharmacy_id =='13012' ){
                     //curexa create order api}
                    $curexa_para = array();
                    $curexa_para['user_id'] = $user_id;
                    $curexa_para['case_id'] = $case_id;
                    $curexa_para['system_case_id'] = $system_case_id;

                    foreach($prescription_data as $key=>$prescription){
                      $curexa_para['rx_id'] =  $prescription->dosespot_prescription_id;
                      $curexa_para['quantity_dispensed'] = $prescription->quantity;
                      $curexa_para['days_supply'] = $prescription->days_supply;
                      $curexa_para['medication_sig'] = $prescription->directions;


                      $curexa_create_order_data = $this->curexa_create_order($curexa_para);

                      if(!empty($curexa_create_order_data)){

                      //pickup_medication_notification

                        if($follow_up_data['follow_up_no'] != 0){

                          $iPledge_items = $follow_up_data['ipledge_items'];
                        }else{
                          $iPledge_items = $$value['ipledge_items'];
                        }

                        if($iPledge_items == 'on') {

                          $noti_input_data = array();
                          $noti_input_data['user_id'] = $user_id;
                          $noti_input_data['case_id'] = $system_case_id;
                          $noti_input_data['md_case_id'] = $case_id;

                          $noti_input_data['noti_message'] = getNotificationMessageFromKey('pickup_medication_notification_for_female');
                          $noti_input_data['for_month'] = $follow_up_data['follow_up_no']+1;

                          $trigger_input = array();
                          $trigger_input['user_id'] = $user_id;
                          $trigger_input['case_id'] = $system_case_id;
                          $trigger_input['md_case_id'] = $case_id;
                          $trigger_input['name'] = "pickup_medication_notification";
                          $trigger_input['month'] = $follow_up_data['follow_up_no']+1;


                          $noti_data = Notifications::create($noti_input_data);

                          $trigger_data = Triggers::create($trigger_input);
                       }
                       

                    //end of pickup_medication_notification


                          $this->store_curexa_order_data($curexa_create_order_data);
                      }
                    }


                    //end of curexa  create order api 
                  } 


                  //Prescription Sent Email

                    $prescriptionemail_data = array();

                    $prescriptionemail_data['email'] = $user_email;
                    $prescriptionemail_data['title'] = 'helloclearhealth.com';
                    $prescriptionemail_data['body'] = "prescription sent";
                    $prescriptionemail_data['template'] = 'emails.mySendMail'; 


                     $prescriptionsmsdata = array();

                    $user = array($user_phone);
                    //$user = array('+917874257069');
                    $prescriptionsmsdata['users'] = $user;
                    $prescriptionsmsdata['body'] = "prescription sent";
                    if($preferred_pharmacy_id !='13012' ){
                        if($follow_up_data['follow_up_no'] == 0  && $value['ipledge_items'] == 'on' && $value['prior_auth_date'] != NULL){

                       
                           $email_sent = sendEmail($prescriptionemail_data);

                          $sms_sent = sendsms($smsdata);
                       }

                   
                  }

                  if($follow_up_data['follow_up_no'] != 0 && $value['ipledge_items'] == 'on'){

                    $email_sent = sendEmail($prescriptionemail_data);

                    $sms_sent = sendsms($prescriptionsmsdata);
                  }
                  //end of Prescription Sent Email  

                  //bloodwork notification

                    $bloodwork_email_data = array();

                    $bloodwork_email_data['email'] = $user_email;
                    $bloodwork_email_data['title'] = 'helloclearhealth.com';
                    $bloodwork_email_data['body'] = "Please complete your blood work ";
                    $bloodwork_email_data['template'] = 'emails.mySendMail';

                    $bloodworksmsdata = array();

                    //$user = array($user_phone);
                    $user = array('+917874257069');
                    $bloodworksmsdata['users'] = $user;
                    $bloodworksmsdata['body'] = "Please complete your blood work";

                if($preferred_pharmacy_id =='13012' && $curexadata['order_status'] == "out_for_delivery" && $difference = 80 ){
                   
                   //send welcome email 
                    $email_sent = sendEmail($bloodwork_email_data); 

                  //welcome sms
                    $sms_sent = sendsms($bloodworksmsdata);
                    
                }

              if($preferred_pharmacy_id !='13012' && $pickup_medication_difference = 60){
                //send welcome email 
                    $email_sent = sendEmail($bloodwork_email_data); 

                  //welcome sms
                    $sms_sent = sendsms($bloodworksmsdata);
              }

                //end of bloodwork notification

              //notification download_the_bloodwork_form

              $had_call_triggers = Triggers::where([['user_id', $user_id],['case_id', $system_case_id],['md_case_id', $case_id],['name','had_call_with_md_notification'],['month',1]])->first();

              $had_call_notification_date = new Carbon($had_call_triggers['updated_at']);
              $current_date = Carbon::now();
              $had_call_difference = $had_call_notification_date->diffInDays($current_date);

              if($had_call_difference == 60){
                $noti_download_the_bloodwork_form = array();
                $noti_download_the_bloodwork_form['user_id'] = $user_id;
                $noti_download_the_bloodwork_form['case_id'] = $case_id;
                $noti_download_the_bloodwork_form['md_case_id'] = $md_case_id;


                $noti_download_the_bloodwork_form['noti_message'] = getNotificationMessageFromKey('download_the_bloodwork_form');
                $noti_download_the_bloodwork_form['for_month'] = $follow_up;

                $noti_download_the_bloodwork_data = Notifications::create($noti_download_the_bloodwork_form);
              }

              //end of notification download_the_bloodwork_form

              //notification upload_your_pregnancy_test

              $ipledge_credentials_triggers = Triggers::where([['user_id', $user_id],['case_id', $system_case_id],['md_case_id', $case_id],['name','ipledge_credentials_sent_notification'],['month',1]])->first();

              $ipledge_credentials_triggers_notification_date = new Carbon($ipledge_credentials_triggers['updated_at']);
              $currentdate = Carbon::now();
              $ipledge_credentials_difference = $ipledge_credentials_triggers_notification_date->diffInDays($currentdate);

              if($ipledge_credentials_difference == 31){
                $noti_download_the_bloodwork_form = array();
                $noti_download_the_bloodwork_form['user_id'] = $user_id;
                $noti_download_the_bloodwork_form['case_id'] = $case_id;
                $noti_download_the_bloodwork_form['md_case_id'] = $md_case_id;


                $noti_download_the_bloodwork_form['noti_message'] = getNotificationMessageFromKey('download_the_bloodwork_form');
                $noti_download_the_bloodwork_form['for_month'] = $follow_up;

                $noti_download_the_bloodwork_data = Notifications::create($noti_download_the_bloodwork_form);
              }

              //end of upload_your_pregnancy_test

              

            }else if($gender == "male" && $product_type == 'Accutane'){


                //send welcome email 

              if( $support_reason != NULL && $follow_up_data['follow_up_no'] == 0){

                $email_data = array();

                $email_data['email'] = $user_email;
                $email_data['title'] = 'helloclearhealth.com';
                $email_data['body'] = "Welcome Email when prescription is approved detailing Accutane instructions + prompt them to sign forms";
                $email_data['template'] = 'emails.mySendMail';

                $email_sent = sendEmail($email_data);
              }
              //end of welcome email 

              //welcome sms
              $smsdata = array();

              $user = array($user_phone);
              $smsdata['users'] = $user;
              $smsdata['body'] = "Welcome SMS to Clear Health when treatment is approved detailing Accutane instructions + prompt them to sign forms";
              $sms_sent = sendsms($smsdata);

              //end of welcome message           


                /*
                  Initial Accutane Male Flow:
            
                  1. Telehealth Visit Requested/ Awaiting Clinician assigned - after vouched verification is done.
                  2. MD Assigned
                  3. Awaiting Prescription Approval
                  4. Prescription Approved
                */

                  //if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'pending' && $case_type = 'new'){
                  if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'assigned'){

                    $system_status = 'MD Assigned';
                  }

                  //if($md_case_status =='support' && $case_type = 'new'){
                  if($md_case_status =='processing' && $prescriptiondata['dosespot_confirmation_status']  == 'pending'){

                    $system_status = ' Awaiting Prescription Approval';
                  }

                  //if($md_case_status == 'dosespot confirmed' && $case_type = 'new'){
                  if($md_case_status == 'completed'){

                    if($follow_up_data['follow_up_no'] == 0){

                     $case_status_reason_input = array();
                     $case_status_reason_input['user_id'] = $user_id;
                     $case_status_reason_input['case_id'] = $system_case_id;
                     $case_status_reason_input['md_case_id'] = $case_id;
                     $case_status_reason_input['name'] = "prescription_sent_notification";
                     $case_status_reason_input['month'] = $follow_up_data['follow_up_no']+1;

                     $case_status_reason_input_data = Triggers::create($case_status_reason_input);

                   }

                    //notification for action_items_due
                     $action_items_due_noti = array();
                    $action_items_due_noti['user_id'] = $user_id;
                    $action_items_due_noti['case_id'] = $system_case_id;
                    $action_items_due_noti['md_case_id'] = $case_id;

                    $action_items_due_noti['noti_message'] = getNotificationMessageFromKey('action_items_due');
                    $action_items_due_noti['for_month'] = $follow_up_data['follow_up_no']+1;
                    $action_items_due_noti_data = Notifications::create($action_items_due_noti);


                    //end of notification for action_items_due

                    $system_status = 'Prescription Approved';


                    //code  for md_has_approved_your_treatment
                    $approved_noti = array();
                    $approved_noti['user_id'] = $user_id;
                    $approved_noti['case_id'] = $system_case_id;
                    $approved_noti['md_case_id'] = $case_id;

                    $approved_noti['noti_message'] = getNotificationMessageFromKey('md_has_approved_your_treatment');
                    $approved_noti['for_month'] = $follow_up_data['follow_up_no']+1;
                    $approved_noti_data = Notifications::create($approved_noti);

                    //end of code for md_has_approved_your_treatment

                    //pickup_medication_notification
                    $noti_input_data = array();
                    $noti_input_data['user_id'] = $user_id;
                    $noti_input_data['case_id'] = $system_case_id;
                    $noti_input_data['md_case_id'] = $case_id;

                    $noti_input_data['noti_message'] = getNotificationMessageFromKey('pickup_medication_notification_for_male');
                    $noti_input_data['for_month'] = $follow_up_data['follow_up_no']+1;

                    $trigger_input = array();
                    $trigger_input['user_id'] = $user_id;
                    $trigger_input['case_id'] = $system_case_id;
                    $trigger_input['md_case_id'] = $case_id;
                    $trigger_input['name'] = "pickup_medication_notification";
                    $trigger_input['month'] = $follow_up_data['follow_up_no']+1;


                    $noti_data = Notifications::create($noti_input_data);

                    $trigger_data = Triggers::create($trigger_input);

                    //end of pickup_medication_notification



                    $response = $this->getPrescription($case_id);

                    if(!empty($response)){
                      //$this->save_prescription_response($response,$user_id,$case_id,$system_case_id);
                     $prescription_data = json_decode($response);

                      if($preferred_pharmacy_id =='13012' ){
                      //curexa create order api   

                     $curexa_para = array();
                     $curexa_para['user_id'] = $user_id;
                     $curexa_para['case_id'] = $case_id;
                     $curexa_para['system_case_id'] = $system_case_id;

                     foreach($prescription_data as $key=>$prescription){
                      $curexa_para['rx_id'] =  $prescription->dosespot_prescription_id;
                      $curexa_para['quantity_dispensed'] = $prescription->quantity;
                      $curexa_para['days_supply'] = $prescription->days_supply;
                      $curexa_para['medication_sig'] = $prescription->directions;


                      $curexa_create_order_data = $this->curexa_create_order($curexa_para);

                      if(!empty($curexa_create_order_data)){
                        $this->store_curexa_order_data($curexa_create_order_data);
                      }
                    }

                    //end of curexa  create order api
                  }

                    //Prescription Sent Email

                    $prescriptionemail_data = array();

                    $prescriptionemail_data['email'] = $user_email;
                    $prescriptionemail_data['title'] = 'helloclearhealth.com';
                    $prescriptionemail_data['body'] = "prescription sent";
                    $prescriptionemail_data['template'] = 'emails.mySendMail'; 


                     $prescriptionsmsdata = array();

                    $user = array($user_phone);
                    //$user = array('+917874257069');
                    $prescriptionsmsdata['users'] = $user;
                    $prescriptionsmsdata['body'] = "prescription sent";

                  //if($follow_up_data['follow_up_no'] == 0 && $value['prior_auth_date'] != NULL){
                  if(empty($follow_up_data) && $value['prior_auth_date'] != NULL){

                    $email_sent = sendEmail($prescriptionemail_data);

                    $sms_sent = sendsms($smsdata);
                  }

                  if($follow_up_data['follow_up_no'] != 0){

                    $email_sent = sendEmail($prescriptionemail_data);

                    $sms_sent = sendsms($prescriptionsmsdata);
                  }
                  //end of Prescription Sent Email  


                }

                //bloodwork notification

                    $bloodwork_email_data = array();

                    $bloodwork_email_data['email'] = $user_email;
                    $bloodwork_email_data['title'] = 'helloclearhealth.com';
                    $bloodwork_email_data['body'] = "Please complete your blood work ";
                    $bloodwork_email_data['template'] = 'emails.mySendMail';

                    $smsdata = array();

                    //$user = array($user_phone);
                    $user = array('+917874257069');
                    $bloodworksmsdata['users'] = $user;
                    $bloodworksmsdata['body'] = "Please complete your blood work";

                if($preferred_pharmacy_id =='13012' && $curexadata['order_status'] == "out_for_delivery" && $difference = 50 ){
                   
                   //send welcome email 
                    $email_sent = sendEmail($bloodwork_email_data); 

                  //welcome sms
                    $sms_sent = sendsms($smsdata);
                    
                }

              if($preferred_pharmacy_id !='13012' && $pickup_medication_difference = 60){
                //send welcome email 
                    $email_sent = sendEmail($bloodwork_email_data); 

                  //welcome sms
                    $sms_sent = sendsms($smsdata);
              }

                //end of bloodwork notification

              //notification download_the_bloodwork_form

              $prescription_sent_triggers = Triggers::where([['user_id', $user_id],['case_id', $system_case_id],['md_case_id', $case_id],['name','prescription_sent_notification'],['month',1]])->first();

              $prescription_sent_notification_date = new Carbon($prescription_sent_triggers['updated_at']);
              $today_date = Carbon::now();
              $prescription_difference = $prescription_sent_notification_date->diffInDays($today_date);

              if($prescription_difference == 60){
                $noti_download_the_bloodwork_form = array();
                $noti_download_the_bloodwork_form['user_id'] = $user_id;
                $noti_download_the_bloodwork_form['case_id'] = $case_id;
                $noti_download_the_bloodwork_form['md_case_id'] = $md_case_id;


                $noti_download_the_bloodwork_form['noti_message'] = getNotificationMessageFromKey('download_the_bloodwork_form');
                $noti_download_the_bloodwork_form['for_month'] = $follow_up;

                $noti_download_the_bloodwork_data = Notifications::create($noti_download_the_bloodwork_form);
              }

              //end of notification download_the_bloodwork_form


              }else{
                /*
                Topical Male & Female:

                1. Telehealth Evaluation Requested
                2. Prescription Approved/Denied
                */

                //if($md_case_status == 'dosespot confirmed' && $case_type = 'new'){
                if($md_case_status == 'completed'){

                  $system_status = 'Prescription Approved';

                  //send notification for topical

                  if($product_type != 'Accutane'){
                    $noti_input_data = array();
                    $noti_input_data['user_id'] = $user_id;
                    $noti_input_data['case_id'] = $system_case_id;
                    $noti_input_data['md_case_id'] = $case_id;

                    $noti_input_data['noti_message'] = getNotificationMessageFromKey('topical_case_completed');
                    $noti_input_data['for_month'] = $follow_up_data['follow_up_no']+1;
                    $noti_data = Notifications::create($noti_input_data);
                  }

                  //end of code to send notification for topical


                  $response = $this->getPrescription($case_id);

                  if(!empty($response)){
                    //$this->save_prescription_response($response,$user_id,$case_id,$system_case_id);

                   $prescription_data = json_decode($response);
                  //curexa create order api

                   $curexa_para = array();
                   $curexa_para['user_id'] = $user_id;
                   $curexa_para['case_id'] = $case_id;
                   $curexa_para['system_case_id'] = $system_case_id;
                   /*foreach($prescription_data as $key=>$prescription){
                      $curexa_para['rx_id'] =  $prescription->dosespot_prescription_id;
                      $curexa_para['quantity_dispensed'] = $prescription->quantity;
                      $curexa_para['days_supply'] = $prescription->days_supply;
                      $curexa_para['medication_sig'] = $prescription->directions;


                      $curexa_create_order_data = $this->curexa_create_order($curexa_para);

                      if(!empty($curexa_create_order_data)){
                          $this->store_curexa_order_data($curexa_create_order_data);
                      }
                      
                    }*/

                  //end of curexa  create order api
                  }  


                  //Prescription Sent Email

                    $prescriptionemail_data = array();

                    $prescriptionemail_data['email'] = $user_email;
                    $prescriptionemail_data['title'] = 'helloclearhealth.com';
                    $prescriptionemail_data['body'] = "prescription sent";
                    $prescriptionemail_data['template'] = 'emails.mySendMail';

                    $email_sent = sendEmail($prescriptionemail_data);
 


                     $prescriptionsmsdata = array();
                    //$user = array($user_phone);
                    $user = array('+917874257069');
                    $prescriptionsmsdata['users'] = $user;
                    $prescriptionsmsdata['body'] = "prescription sent";
                    
                    $sms_sent = sendsms($smsdata);
                  
                }
              }

              $case_management  =  CaseManagement::where('id',$system_case_id)->where('md_case_id', $case_id)->where('user_id',$user_id)->update(['md_case_status' => $MdCaseStatus->case_status->name,'md_status' => $md_status,'system_status'=> $system_status ]);


              $md_cases  =  Mdcases::where('case_id',$case_id)->update(['status' =>$MdCaseStatus->case_status->name,'system_status'=> $system_status],['case_status_reason' =>$MdCaseStatus->case_status->reason],['case_status_updated_at' =>$MdCaseStatus->case_status->updated_at]);

              //if($follow_up_data['follow_up_no'] == 0 && $MdCaseStatus->case_status->reason != null){
              if(empty($follow_up_data) && $MdCaseStatus->case_status->reason != null){

                 $case_status_reason_input = array();
                 $case_status_reason_input['user_id'] = $user_id;
                 $case_status_reason_input['case_id'] = $system_case_id;
                 $case_status_reason_input['md_case_id'] = $case_id;
                 $case_status_reason_input['name'] = "had_call_with_md_notification";
                 $case_status_reason_input['month'] = $follow_up_data['follow_up_no']+1;

                 $case_status_reason_input_data = Triggers::create($case_status_reason_input);

              }

               //code for update md details

              if($MdCaseStatus->case_assignment != null){
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


            if($value['curexa_order_id']!= '' || $value['curexa_order_id']!= NULL){
              $curexa_order_status = $this->curexa_order_status();

              $curexa_ord_status = json_decode($curexa_order_status);

              $CurexaOrderStatus  =  CurexaOrder::where('id',$value['curexa_order_id'])->update(['order_status' => $curexa_ord_status->status,'status_details' => $curexa_ord_status->status_details,'tracking_number'=> $curexa_ord_status->tracking_number]);

              if($curexa_ord_status->status == 'out_for_delivery' && $product_type != 'Accutane'){

                 $noti_input_data = array();
                 $noti_input_data['user_id'] = $user_id;
                 $noti_input_data['case_id'] = $case_id;
                 $noti_input_data['md_case_id'] = $md_case_id;

                 $noti_msg = getNotificationMessageFromKey('order_shipped');

                 $noti_message = str_replace("[order_id]",$value['curexa_order_id'], $noti_msg);

                 $noti_input_data['noti_message'] =  $noti_message;
                 $noti_input_data['for_month'] = $follow_up;

                  $noti_data = Notifications::create($noti_input_data);
              }
            }

          }
            //md status completed

        }
      }



    }
      //end code

    //shippstation

    //end of shipstation
  }
}
}

  
}

public function getShipStationOrderStatus(Request $request){
  $checkout_order = Checkout::select('id','order_id','user_id','cart_id','case_id','md_case_id','medication_type','shipstation_order_id','shipstation_order_status')
              ->whereNotNull('shipstation_order_id')
              ->whereNotNull('shipstation_order_status')
              ->orderBy('id','desc')
              ->get();

      if(count($checkout_order)>0){
        foreach($checkout_order as $chkey => $chval){
          
            
            $shipord = shipStationHelper::getOrderData($chval['shipstation_order_id']);
            if(!empty($shipord)){
              $status = json_decode(json_encode($shipord), true);
              if($status['orderStatus'] == 'shipped'){
                $addNot = new Notifications();
                $addNot->user_id = $chval['user_id'];
                $addNot->case_id = $chval['case_id'];
                // $addNot->md_case_id = $orderData['md_case_id'];
                $addNot->order_id = $chval['id'];
                $addNot->noti_message = "Your order #".$chval['order_id']." has been shipped!";
                $addNot->save(); 
              }
              sleep(1);
            } 
        }
  }     
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


    public function getPrescription($case_id){

      $r = get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/prescriptions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      //echo $response;

      return $response;

    }

    public function save_prescription_response($response,$user_id,$case_id,$system_case_id){
      $prescription_data = json_decode($response);

      foreach($prescription_data as $key=>$prescription){

         // $prescription = json_decode(json_encode($prescription), true);

         // echo "<pre> data is ";
         // print_r($prescription->dosespot_prescription_sync_status);
         // echo "<pre>";
         // exit();

          // echo "<pre>";
          // print_r($prescription);
          // echo "<pre>";
          // exit();

        $input_prescription['dosespot_prescription_id'] = (isset($prescription->dosespot_prescription_id)) ? $prescription->dosespot_prescription_id : NULL;


        $input_prescription['dosespot_prescription_sync_status'] = $prescription->dosespot_prescription_sync_status;
        $input_prescription['dosespot_confirmation_status'] = $prescription->dosespot_confirmation_status;


        $input_prescription['dosespot_confirmation_status_details'] = ($prescription->dosespot_confirmation_status_details !='') ? $prescription->dosespot_confirmation_status_details : NULL;
        $input_prescription['refills'] = $prescription->refills;
        $input_prescription['quantity'] = $prescription->quantity;
        $input_prescription['days_supply'] = $prescription->days_supply;
        $input_prescription['no_substitutions'] = $prescription->no_substitutions;
        $input_prescription['pharmacy_notes'] = ($prescription->pharmacy_notes != '') ? $prescription->pharmacy_notes : NULL;
        $input_prescription['directions'] = $prescription->directions;
        $input_prescription['dispense_unit_id'] = $prescription->dispense_unit_id;
        $input_prescription['preferred_pharmacy_id'] = $prescription->pharmacy_id;
        $input_prescription['case_id'] = '"'.$case_id.'"';
        $input_prescription['user_id'] = $user_id;
        $input_prescription['system_case_id'] = $system_case_id;

            /*echo "<pre>";
            print_r($input_prescription);
            echo "<pre>"; 
            exit();*/

            $CasePrescription_data = CasePrescriptions::create($input_prescription);
            
            if(isset($prescription->medication) && !empty($prescription->medication)){
              $input_medication['case_prescription_id'] = $CasePrescription_data->id;
              $input_medication['dosespot_medication_id'] = $prescription->medication->dosespot_medication_id;
              $input_medication['dispense_unit_id'] = $prescription->medication->dispense_unit_id;
              $input_medication['dose_form'] = $prescription->medication->dose_form;
              $input_medication['route'] = $prescription->medication->route;
              $input_medication['strength'] = $prescription->medication->strength;
              $input_medication['generic_product_name'] = $prescription->medication->generic_product_name;
              $input_medication['lexi_gen_product_id'] = $prescription->medication->lexi_gen_product_id;
              $input_medication['lexi_drug_syn_id'] = $prescription->medication->lexi_drug_syn_id;
              $input_medication['lexi_synonym_type_id'] = $prescription->medication->lexi_synonym_type_id;
              $input_medication['lexi_gen_drug_id'] = $prescription->medication->lexi_gen_drug_id;
              $input_medication['rx_cui'] = $prescription->medication->rx_cui;
              $input_medication['otc'] = $prescription->medication->otc;
              $input_medication['ndc'] = $prescription->medication->ndc;
              $input_medication['schedule'] = $prescription->medication->schedule;
              $input_medication['display_name'] = $prescription->medication->display_name;
              $input_medication['monograph_path'] = $prescription->medication->monograph_path;
              $input_medication['drug_classification'] = $prescription->medication->drug_classification;
              $input_medication['state_schedules'] = json_encode($prescription->medication->state_schedules);

              $CasePrescription_data = PrescriptionMedication::create($input_medication);

            }

            if(!empty($prescription->partner_compound)){
             $input_compound['case_prescription_id'] = $CasePrescription_data->id;
             $input_compound['partner_compound_id'] = $prescription->partner_compound->partner_compound_id;
             $input_compound['title'] = $prescription->partner_compound->title;

             $CasePrescription_data = PrescriptionCompound::create($input_compound);
           }

         }

       }


       public function curexa_create_order($curexa_para){

         $user_id = $curexa_para['user_id'];
         $case_id = $curexa_para['case_id'];
         $system_case_id =$curexa_para['system_case_id'] ;

         $md_deatail = Mdmanagement::where([['case_id', $case_id]])->get()->toArray();


         $order_data = Checkout::where([['user_id', $user_id],['case_id', $case_id],['md_case_id', $system_case_id]])->get()->toArray();
         if(!empty($order_data)){
          $order_id = $order_data['id'];

          $user = User::find($user_id);


          $userQueAns = getQuestionAnswerFromUserid($user_id,$case_id);

          foreach ($userQueAns as $key => $value) {

            $question = $value->question;

            if($question == "Please list medications that you are allergic to."){
              if(isset($value->answer) && $value->answer!=''){

                $allergies =  $value->answer;

              }
            }

            if($question == "Please list any other medications that you’re currently taking."){
              if(isset($value->answer) && $value->answer!=''){

                $current_medications =  $value->answer;

              }
            }

          }

          $shipping_address = Checkoutaddress::select('*')
          ->where('checkout_address.order_id',$order_id)
          ->where('checkout_address.address_type',1)
          ->OrderBy('id', 'DESC')
          ->first();

          $patient_id = $user['md_patient_id'];

          if($patient_id != '' || $patient_id != NULL ){

           $patient_data =   Mdpatient::where('patient_id', $patient_id)->get()->toArray();

           $gender =  $patient_data['gender'];

           if($gender == 1){
            $patient_gender = 'Male';
          }else if($gender == 2){
            $patient_gender = 'Female';
          }else{
            $patient_gender = 'Not known';
          }
            /*  0 = Not known;
                1 = Male;
                2 = Female;
                9 = Not applicable.
            */

                $patient_dob = date('Ymd', strtotime($patient_data['dob']));


                //medicin name
                $product_type = getUserProduct($user_id,$case_id);


                if($product_type == 'Topical_low'){

                 $product_name = "Low Tretinoin 0.04% Topical";

               }

               if($product_type == 'Topical_high'){

                 $product_name = "High Tretinoin 0.09% Topical";

               }

               if($product_type == 'Azelaic_Acid'){

                 $product_name = "Azelaic Acid 5% Topical";

               }
               if($product_type == 'Accutane'){

                 $product_name = "Isotretinoin capsules";

               }

                //end of code for medicin name


                $rx_items= array();

                $rx_items['rx_id'] = $curexa_para['rx_id'];
                $rx_items['medication_name'] = $product_name;
                $rx_items['quantity_dispensed'] = $curexa_para['quantity_dispensed'];
                $rx_items['days_supply'] = $curexa_para['days_supply'];
                $rx_items['prescribing_doctor'] =  $md_deatail['name'];
                $rx_items['medication_sig'] = $curexa_para['medication_sig'];
                $rx_items['non_child_resistant_acknowledgment'] = false;



                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.curexa.com/orders',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "order_id": '.$order_id.',
                    "patient_id":'. $patient_id.',
                    "patient_first_name": '.$patient_data['first_name'].',
                    "patient_last_name": '.$patient_data['last_name'].',
                    "patient_dob": '.$patient_dob.',
                    "patient_gender":'.$patient_gender.',
                    "carrier":"USPS,",
                    "shipping_method":"",
                    "address_to_name":'.$shipping_address['patient_firstname'].' '.$shipping_address['patient_lastname'].',
                    "address_to_street1":'.$shipping_address['addressline1'].',
                    "address_to_street2":'.$shipping_address['addressline2'].',
                    "address_to_city":'.$shipping_address['city'].',
                    "address_to_state":'.$shipping_address['state'].',
                    "address_to_zip":'.$shipping_address['zipcode'].',
                    "address_to_country":"US",
                    "address_to_phone":'.$shipping_address['phone'].',
                    "notes":"Test",
                    "patient_known_allergies":'.(isset($allergies))?$allergies:''.',
                    "patient_other_medications":'.(isset($current_medications))?$current_medications:''.',
                    "rx_items":'.json_encode($rx_items).'
                  }',
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic Y2xlYXJoZWFsdGhfdGVzdF9Ya1Fzdk1sbVFKbXRWSlBIbGJnWE9WSVd3UU5ETXQxNDpvRW5NZTJITnZndGQzaW9wNm96aWdTZHRmZUJkQUNCNw==',
                    'Content-Type: application/json'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                return $response;

              }

            }

          }


          public function curexa_order_status($order_id){
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.curexa.com/order_status',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "order_id": '.$order_id.'
              }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic Y2xlYXJoZWFsdGhfdGVzdF9Ya1Fzdk1sbVFKbXRWSlBIbGJnWE9WSVd3UU5ETXQxNDpvRW5NZTJITnZndGQzaW9wNm96aWdTZHRmZUJkQUNCNw==',
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
          }

          public function store_curexa_order_data($curexa_create_order_data){
            $curexa_order_data = json_decode($curexa_create_order_data);

            $order_data = array();
            $order_data['order_id'] = $curexa_order_data['order_id'];
            $order_data['rx_item_count'] = $curexa_order_data['rx_item_count'];
            $order_data['otc_item_count'] = $curexa_order_data['otc_item_count'];
            $order_data['status'] = $curexa_order_data['status'];
            if($curexa_order_data['status'] == 'out_for_delivery'){
              $order_data['dispached_date'] = Carbon::now();
            }
            $order_data['message'] = $curexa_order_data['message'];

            $inserted_data = CurexaOrder::create($order_data);
            $curexa_order_id = $inserted_data->id;

            $case_management  =  CaseManagement::where('id', $system_case_id)->where('md_case_id', $case_id)->where('user_id',$user_id)->update(['curexa_order_id' => $curexa_order_id]);
          }

          public function testemail(){
           $user_email = sendEmail();

           echo "<pre>";
           print_r($user_email);
           echo "<pre>";
           exit();
         }

         public function testsms(){

          $data = array();

          $user = array("+917874257069");
          $data['users'] = $user;
          $data['body'] = "Hello clear health test sms";
          sendsms($data);
        }

      }
