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
      
      $user_email =  $data['email'];

      $user_phone = $data['mobile'];
    

      $r = get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      foreach($data as $key=>$value){

         $follow_up_data = Mdcases::join('case_managements','case_managements.md_case_id', '=','md_cases.case_id' )->join('follow_up','follow_up.md_case_id', '=','md_cases.case_id' )->select('follow_up.follow_up_no')->where('case_managements.md_case_id',$value['md_case_id'])->get()->toArray();

        $user_id = $value['user_id'];
        $case_id = $value['md_case_id'];
        $system_case_id = $value['id'];

        $gender = 'Not known';//0;

        $product_type = $value['product_type'];

        $system_status = 'Telehealth Evaluation Requested';


        if($value['md_case_status']!= 'completed'){

          $userQueAns = getQuestionAnswerFromUserid($user_id,$system_case_id);

          if(!empty($userQueAns)){
            foreach ($userQueAns as $k => $val) {
             $question = $val->question;
             if($question == "What was your gender assigned at birth?"){
               if(isset($val->answer) && $val->answer!=''){

                $gender =  $val->answer;
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

           // $md_case_status = $MdCaseStatus->case_status->name;//enable this aafter testing is done

          $md_case_status = 'completed'; //remove this

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


          $prescriptiondata = CasePrescriptions::where([['user_id',$user_id],['case_id',$case_id],['system_case_id',$system_case_id]])->first();


          //if($gender == "Female" && $product_type == 'Accutane' && $case_type = 'new'){
          if($gender == "Female" && $product_type == 'Accutane'){ 


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

                  $system_status = 'Prescription Approved';
              

                  $response = $this->getPrescription($case_id);

              
                  if(!empty($response)){
                    $this->save_prescription_response($response,$user_id,$case_id,$system_case_id);
                    $prescription_data = json_decode($response);

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


                }
                

                if($follow_up_data['follow_up_no'] == 0){

                  if($md_case_status == 'completed' && $value['abstinence_form']!= 0 && $value['sign_ipledge_consent']!= 0){

                  $system_status = 'Awaiting Action Items';  

                  }
                }

                if($follow_up_data['follow_up_no'] != 0){

                  if($md_case_status == 'completed' && $value['prior_auth_date'] != NULL){

                    $prior_auth_date = new Carbon($value['prior_auth_date']);
                    $now = Carbon::now();
                    $checkdate = $prior_auth_date->addDays(7);

                    echo "<pre>";
                    print_r($now);
                    echo "<pre>";

                    echo "<pre>";
                    print_r($checkdate);
                    echo "<pre>";
               

                    if($now->lte($checkdate)){
                        $system_status = 'Awaiting Action Items'; 
                    } 

                  }
                }

                

              }else if($gender == "Male" && $product_type == 'Accutane'){


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

                    $system_status = 'Prescription Approved';

                    $response = $this->getPrescription($case_id);

                    if(!empty($response)){
                      $this->save_prescription_response($response,$user_id,$case_id,$system_case_id);
                       $prescription_data = json_decode($response);
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


                  }


                }else{
                /*
                Topical Male & Female:

                1. Telehealth Evaluation Requested
                2. Prescription Approved/Denied
                */

                //if($md_case_status == 'dosespot confirmed' && $case_type = 'new'){
                 if($md_case_status == 'completed'){

                  $system_status = 'Prescription Approved';

             
                  $response = $this->getPrescription($case_id);
                   
                  if(!empty($response)){
                    $this->save_prescription_response($response,$user_id,$case_id,$system_case_id);

                     $prescription_data = json_decode($response);
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

                }
              }

              $case_management  =  CaseManagement::where('id',$system_case_id)->where('md_case_id', $case_id)->where('user_id',$user_id)->update(['md_case_status' => $MdCaseStatus->case_status->name,'md_status' => $md_status,'system_status'=> $system_status ]);


               $md_cases  =  Mdcases::where('case_id',$case_id)->update(['status' =>$MdCaseStatus->case_status->name,'system_status'=> $system_status]);

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
            $input_prescription['dosespot_prescription_id'] = ($prescription->dosespot_prescription_id!='') ? $prescription->dosespot_prescription_id : NULL;
            $input_prescription['dosespot_prescription_sync_status'] = $prescription->dosespot_prescription_sync_status;
            $input_prescription['dosespot_confirmation_status'] = $prescription->dosespot_confirmation_status;
            $input_prescription['dosespot_confirmation_status_details'] =($prescription->dosespot_confirmation_status_details !='')? $prescription->dosespot_confirmation_status_details : NULL;
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
        $order_id = $order_data['order_id'];

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


                $rx_items= array();

                $rx_items['rx_id'] = $curexa_para['rx_id'];
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
                    "carrier":"FEDEX",
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
