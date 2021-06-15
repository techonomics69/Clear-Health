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

          $case_type = getCaseType($user_id,$case_id,$system_case_id);



          if($gender == "Female" && $recommended_product == 'Accutane' && $case_type = 'new'){

                /*
                1.   Telehealth Evaluation Requested -> sent to MD Integrations  (case status MD side = pending )
                2.   Awaiting Live Consultation -> MD assigned, call not initiated ( MD guys will call ping our API using webhook and we will get notified that MD has been assigned)
                3.   Awaiting Follow-Up -> (case status received as support from MD)
                4.   Awaiting Prescription Approval(Follow up ->send case to md )
                5.   Prescription Approved -> (prescription confirmed by dosespot/script is written i.e. case status received from MD = Dosespot confirmed)
                6.   Awaiting Action Items
                */
                if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'pending' && $case_type = 'new'){

                  $system_status = 'Awaiting Live Consultation';
                }

                if($md_case_status == 'support' && $case_type = 'new'){

                  $system_status = 'Awaiting Follow-Up';
                }

                if($md_case_status =='support' && $case_type = 'follow_up'){

                  $system_status = ' Awaiting Prescription Approval';
                }

                if($md_case_status == 'dosespot confirmed' && $case_type = 'follow_up'){

                  $system_status = 'Prescription Approved';
                }
                

                if($md_case_status == 'dosespot confirmed' && $value['pregnancy_test']!= NULL && $value['blood_work']!= NULL && $value['i_pledge_agreement']!= NULL){

                  $system_status = 'Awaiting Action Items';

                  $response = $this->getPrescription($case_id);

                  if(!empty($response)){
                    $this->save_prescription_response($response);
                  } 

                  //curexa create order api

                  $this->curexa_create_order($user_id,$case_id,$system_case_id);

                  //end of curexa  create order api      

                }

              }else if($gender == "Male" && $recommended_product == 'Accutane'){
                /*
                  Initial Accutane Male Flow:
            
                  1. Telehealth Visit Requested/ Awaiting Clinician assigned - after vouched verification is done.
                  2. MD Assigned
                  3. Awaiting Prescription Approval
                  4. Prescription Approved
                */

                  if(($md_status != null || $value['md_status']!= null) && $md_case_status == 'pending' && $case_type = 'new'){

                    $system_status = 'MD Assigned';
                  }

                  if($md_case_status =='support' && $case_type = 'new'){

                    $system_status = ' Awaiting Prescription Approval';
                  }

                  if($md_case_status == 'dosespot confirmed' && $case_type = 'new'){

                    $system_status = 'Prescription Approved';



                    $response = $this->getPrescription($case_id);

                    if(!empty($response)){
                      $this->save_prescription_response($response);
                    }


                    //curexa create order api   

                    $this->curexa_create_order($user_id,$case_id,$system_case_id);

                    //end of curexa  create order api


                  }


                }else{
                /*
                Topical Male & Female:

                1. Telehealth Evaluation Requested
                2. Prescription Approved/Denied
                */

                if($md_case_status == 'dosespot confirmed' && $case_type = 'new'){

                  $system_status = 'Prescription Approved';



                  
                  $response = $this->getPrescription($case_id);

                  if(!empty($response)){
                    $this->save_prescription_response($response);
                  }  

                  //curexa create order api

                  $this->curexa_create_order($user_id,$case_id,$system_case_id);

                  //end of curexa  create order api
                }
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

    public function save_prescription_response($response){
      $prescription_data = json_decode($response);

      $input_prescription['dosespot_prescription_id'] = $prescription_data->dosespot_prescription_id;
      $input_prescription['dosespot_prescription_sync_status'] = $prescription_data->dosespot_prescription_sync_status;
      $input_prescription['dosespot_confirmation_status'] = $prescription_data->dosespot_confirmation_status;
      $input_prescription['dosespot_confirmation_status_details'] = $prescription_data->dosespot_confirmation_status_details;
      $input_prescription['refills'] = $prescription_data->refills;
      $input_prescription['quantity'] = $prescription_data->quantity;
      $input_prescription['days_supply'] = $prescription_data->days_supply;
      $input_prescription['no_substitutions'] = $prescription_data->no_substitutions;
      $input_prescription['pharmacy_notes'] = $prescription_data->pharmacy_notes;
      $input_prescription['directions'] = $prescription_data->directions;
      $input_prescription['dispense_unit_id'] = $prescription_data->dispense_unit_id;
      $input_prescription['preferred_pharmacy_id'] = $prescription_data->preferred_pharmacy_id;
      $input_prescription['case_id'] = $case_id;
      $input_prescription['user_id'] = $user_id;
      $input_prescription['system_case_id'] = $case_id;

      $CasePrescription_data = CasePrescriptions::create($input_prescription);

      if(isset($prescription_data->medication) && !empty($prescription_data->medication)){
        $input_medication['dosespot_medication_id'] = $prescription_data->medication->dosespot_medication_id;
        $input_medication['dispense_unit_id'] = $prescription_data->medication->dispense_unit_id;
        $input_medication['dose_form'] = $prescription_data->medication->dose_form;
        $input_medication['route'] = $prescription_data->medication->route;
        $input_medication['strength'] = $prescription_data->medication->strength;
        $input_medication['generic_product_name'] = $prescription_data->medication->generic_product_name;
        $input_medication['lexi_gen_product_id'] = $prescription_data->medication->lexi_gen_product_id;
        $input_medication['lexi_drug_syn_id'] = $prescription_data->medication->lexi_drug_syn_id;
        $input_medication['lexi_synonym_type_id'] = $prescription_data->medication->lexi_synonym_type_id;
        $input_medication['lexi_gen_drug_id'] = $prescription_data->medication->lexi_gen_drug_id;
        $input_medication['rx_cui'] = $prescription_data->medication->rx_cui;
        $input_medication['otc'] = $prescription_data->medication->otc;
        $input_medication['ndc'] = $prescription_data->medication->ndc;
        $input_medication['schedule'] = $prescription_data->medication->schedule;
        $input_medication['display_name'] = $prescription_data->medication->display_name;
        $input_medication['monograph_path'] = $prescription_data->medication->monograph_path;
        $input_medication['drug_classification'] = $prescription_data->medication->drug_classification;
        $input_medication['state_schedules'] = $prescription_data->medication->state_schedules;

        $CasePrescription_data = PrescriptionMedication::create($input_medication);

      }



      if(!empty($prescription_data->partner_compound)){
       $input_compound['partner_compound_id'] = $prescription_data->partner_compound->partner_compound_id;
       $input_compound['title'] = $prescription_data->partner_compound->title;

       $CasePrescription_data = PrescriptionCompound::create($input_compound);
     }


   }


   public function curexa_create_order($user_id,$case_id,$system_case_id){

    $order_data = Checkout::where([['user_id', $user_id],['case_id', $case_id],['md_case_id', $system_case_id]])->get()->toArray();

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
              "patient_other_medications":'.(isset($current_medications))?$current_medications:''.'
            }',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic Y2xlYXJoZWFsdGhfdGVzdF9Ya1Fzdk1sbVFKbXRWSlBIbGJnWE9WSVd3UU5ETXQxNDpvRW5NZTJITnZndGQzaW9wNm96aWdTZHRmZUJkQUNCNw==',
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          echo $response;

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
        echo $response;
      }








    }
