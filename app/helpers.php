<?php
//use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Validator;
//use Exception;
//use File;

use App\Models\CaseManagement;
use App\Models\Mdpatient;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Parentdetail;
use App\Models\Mdcases;
use App\Models\Mdmanagement;
use App\Models\CaseFiles;
use App\Models\MdMessages;
use App\Models\MdMessageFiles;
use App\Models\Answers;
use App\Models\MessageFiles;
use App\Models\Messages;

function get_token(){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/auth/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
      "grant_type": "client_credentials",
      "client_id": "c7a20a90-4db9-42e4-860a-7f41c2a8a0b1",
      "client_secret": "xBsQsgLFhYIFNlKwhJW3wClOmNuJ4WQDX0n8475C",
      "scope": "*"
    }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return $response;
}

function create_patient($user_id,$case_id)
{
	$r = get_token();
	$token_data = json_decode($r);
	$token = $token_data->access_token;

  $allergies="";
  $current_medications="";
  $weight = 0;
  $height= 0;

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

  if($question == "What is your weight in lbs?"){
    if(isset($value->answer) && $value->answer!=''){

      $weight =  $value->answer;

    }
  }

  if($question == "What is your Height?"){
    if(isset($value->answer) && $value->answer!=''){

      $height =  $value->answer;

    }


  }
}

$user_data = User::where('id', $user_id)->first();



$input_data = array();
$address = array();

$input_data['first_name'] = $user_data['first_name'];
$input_data['last_name'] = $user_data['last_name'];
$input_data['gender'] = $user_data['gender'];
$input_data['date_of_birth'] = $user_data['dob'];
$input_data['phone_number'] = $user_data['mobile'];
$input_data['phone_type'] = 2;
$input_data['email'] = $user_data['email'];
$address['address'] = $user_data['address'];
$address['city_id'] = '31f5afce-1c7f-4636-b9b4-3874a177de90';//$user_data['city_id'];
$address['zip_code'] = $user_data['zip'];
$input_data['address'] = $address;
$input_data['height'] = $height;
$input_data['weight'] = $weight;
$input_data['current_medications'] = $current_medications;
$input_data['allergies'] = $allergies;

$input = json_encode($input_data);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/patients',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$input,
  CURLOPT_HTTPHEADER => array(
   'Content-Type: application/json',
   'Authorization: Bearer '. $token
 ),
));

$response = curl_exec($curl);


$Patient_data = json_decode($response);

if(!empty($Patient_data)){

  $input_data['partner_id'] = $Patient_data->partner_id;
  $input_data['first_name'] = $Patient_data->first_name;
  $input_data['last_name'] =  $Patient_data->last_name;
  $input_data['email'] =  $Patient_data->email;
  $input_data['gender'] = $Patient_data->gender;
  $input_data['phone_number'] = $Patient_data->phone_number;
  $input_data['phone_type'] = $Patient_data->phone_type;
  $input_data['date_of_birth'] = $Patient_data->date_of_birth;
  $input_data['active'] = $Patient_data->active;
  $input_data['weight'] = $Patient_data->weight;
  $input_data['height'] = $Patient_data->height;
  $input_data['dosespot_sync_status'] = $Patient_data->dosespot_sync_status;
  $input_data['patient_id'] = $Patient_data->patient_id;
  $input_data['gender_label'] = $Patient_data->gender_label;
  $input_data['address'] = $Patient_data->address->address;
  $input_data['zip_code'] = $Patient_data->address->zip_code;
  $input_data['city_id'] = $Patient_data->address->city_id;
  $input_data['city_name'] = $Patient_data->address->city->name;
  $input_data['state_name'] = $Patient_data->address->city->state->name;
  $input_data['state_abbreviation'] = $Patient_data->address->city->state->abbreviation;


  $md_patient_data = Mdpatient::create($input_data);

            //$info = curl_getinfo($curl);

       /*if(curl_exec($curl) == false)
       {
        echo 'Curl error: ' . curl_error($curl);
              //return $this->sendResponse($response, 'Patient Created Successfully1'); 
      }
      else
      {
      	return $this->sendResponse($input_data,'Patient Created Successfully'); 
     }*/
     return $Patient_data->patient_id;
      
    }
  }


    function createCaseFile(Request $request){

      $r = $this->get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      $documents = $request->file('file');
      $name = $request->name;
      $user_id = $request->user_id;
      $case_id = $request->case_id;
      $system_case_id = $request->system_case_id;

      if(!empty($documents)){
        $file =  $documents->getClientOriginalName();
        $doc_file_name =  time().'-'.$file;

        if (!file_exists(public_path('/MD_Case_files'))) {
          File::makeDirectory(public_path('/MD_Case_files'),0777,true,true);
        }
        $destinationPath = public_path('/MD_Case_files');
        $documents->move($destinationPath, $doc_file_name);

        chmod($destinationPath."/".$doc_file_name, 0777);

        $file_path = 'public/MD_Case_files/' .$file;
      }

    //$file_temp_name = $documents->getfileName();
    //$file_temp_path = $documents->getpathName();
    //$file_mimeType = $documents->getClientMimeType();

      $input_data = $request->all();

      $fields = [
        'name' => $name,
      //'file' => new \CurlFile($file_temp_path,$file_mimeType, $doc_file_name)
        'file' => new \CurlFile($destinationPath."/".$doc_file_name)
      ];

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/files',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>  $fields,
        CURLOPT_HTTPHEADER => array(
          'Content: multipart/form-data;',
          'Authorization: Bearer '.$token,
          'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
        ),
      ));

      $response = curl_exec($curl);

   /* if($errno = curl_errno($curl)) {
      $error_message = curl_strerror($errno);
      echo "cURL error ({$errno}):\n {$error_message}";
    }*/

    curl_close($curl);

    $case_file_data = json_decode($response);

    $input_data['name'] = $case_file_data->name;
    $input_data['file'] = $doc_file_name;
    $input_data['mime_type'] = $case_file_data->mime_type;
    $input_data['url'] = $case_file_data->url;
    $input_data['url_thumbnail'] = $case_file_data->url_thumbnail;
    $input_data['file_id'] = $case_file_data->file_id;
    $input_data['case_id'] = $case_id;
    $input_data['system_file'] = $file_path;
    $input_data['user_id'] = $user_id;
    $input_data['system_case_id'] = $system_case_id;
    //attach file to case_id

    $curl1 = curl_init();

    curl_setopt_array($curl1, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/files/'.$case_file_data->file_id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token,
        'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
      ),
    ));

    $response1 = curl_exec($curl1);

    $md_case_file_data = json_decode($response1);

    $input_data['md_file_name'] = $md_case_file_data->name;
    $input_data['md_mime_type'] = $md_case_file_data->mime_type;
    $input_data['md_url'] = $md_case_file_data->url;
    $input_data['md_url_thumbnail'] = $md_case_file_data->url_thumbnail;
    $input_data['md_file_id'] = $md_case_file_data->file_id;

    $case_file_data = CaseFiles::create($input_data);


    curl_close($curl1);


    //end of code to attach file to case_id


    return $this->sendResponse($case_file_data,'File Created Successfully');

  }

  function getPharmacyById($pharmacy_id){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;



    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/pharmacies/'.$pharmacy_id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token,
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);


    return $response;


  }

  function CreateCase($user_id,$case_id,$preferred_pharmacy_id,$patient_id){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    /*$patient_data = User::select('md_patient_id')->where('id', $user_id)->first();

    $patient_id = '"'.$patient_data['md_patient_id'].'"';*/

    $patient_id = '"'.$patient_id.'"';

    $recommended_product = CaseManagement::select('recommended_product')->where('id',$case_id)->where('user_id',$user_id)->first();

    $recommended_product = $recommended_product['recommended_product'];

    if($recommended_product == 'Topical_low'){

     $product_name = "Topical Low";

   }

   if($recommended_product == 'Topical_high'){

     $product_name = "Topical High";

   }

   if($recommended_product == 'Azelaic_Acid'){

     $product_name = "Azelaic Acid";

   }
   if($recommended_product == 'Accutane'){

     $product_name = "ISOtretinoin (oral - capsule)";

   }

   $removed_space_pro_name = str_replace(" ","%20",$product_name);

    //code to get user's question answer

    /*$answer = QuizAnswer::join('quizzes', 'quizzes.id', '=', 'quiz_answers.question_id')->where('quiz_answers.user_id', $request['user_id'])->where('quiz_answers.case_id', $request['case_id'])->select( 'quizzes.question','quiz_answers.answer','quizzes.options_type')->get()->toArray();

    $userquestion = array();
    foreach($answer as $key=>$value){
      $userquestion[$key]['question'] = $value['question'];
      $userquestion[$key]['answer'] = $value['answer'];

      if($value['options_type'] == "radio"){
       $userquestion[$key]['type']= "boolean";
     }else{
       $userquestion[$key]['type']= "string";
     }
     
     $userquestion[$key]['important']= true;
   }
   
   $userquestion = json_encode($userquestion);*/ //old logic

   $userQueAns = getQuestionAnswerFromUserid($user_id,$case_id);

 //get weight of patient 

   //$answer = QuizAnswer::join('quizzes', 'quizzes.id', '=', 'quiz_answers.question_id')->where('quiz_answers.user_id', $request['user_id'])->where('quiz_answers.case_id', $request['case_id'])->where('quiz_answers.case_id', $request['case_id'])->select( 'quizzes.question','quiz_answers.answer','quizzes.options_type')->get()->toArray();


   $accutan_strength = 30;
   foreach ($userQueAns as $key => $value) {

    $question = $value->question;

    
  }
//end of code to get patient weight 
  $userquestion = array();
  foreach($userQueAns as $key=>$value){

      $question = $value->question;

      if($question == "What is your weight in lbs??"){
        if(isset($value->answer) && $value->answer!=''){

        $answer =  $value->answer;

        if($answer > 154){
          $accutan_strength = 40;
        }else{
          $accutan_strength = 30;
        }   
      }
    }

    if(isset($value->answer) && $value->answer!=''){
      $userquestion[$key]['question'] = $value->question;

      if(is_array($value->answer)){
       $userquestion[$key]['answer'] = implode(',',$value->answer);
     }else{

        if($question =='How would you rate your stress level on a scale of 1 to 10?'){
             $userquestion[$key]['answer'] = string($value->answer);
        }else{
          $userquestion[$key]['answer'] = $value->answer;
        }
       
     }

     

     if($value->options_type == "radio"){
       $userquestion[$key]['type']= "boolean";
     }else{
       $userquestion[$key]['type']= "string";
     }

     $userquestion[$key]['important']= true;

   }

 }

 $userquestion = json_encode($userquestion);

  //end of code to get user's question answer



 if($recommended_product !="Accutane"){

  $days_supply = "60";
  $refills = "11";
  $directions = "Take one at the morning and another before bed";
  $no_substitutions = "false";
  $pharmacy_notes =  "";
  $quantity = 30;


      /*$DispensUnitId = $this->getDispensUnitId();

      $DispensUnitId = json_decode($DispensUnitId);
      
      $DispensUnitId= $DispensUnitId[0]->dispense_unit_id;*/

      $DispensUnitId = 8;



      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/compounds/search?name='.$removed_space_pro_name,
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

      curl_close($curl);

      $compounds= $response;


      $compounds = json_decode($compounds);

      $partner_compound_id = $compounds[0]->partner_compound_id;

      $medication_compound_data = array();
      $medication_compound_data[0]['partner_compound_id'] = $partner_compound_id;
      $medication_compound_data[0]['refills'] = $refills;
      $medication_compound_data[0]['quantity'] = $quantity;
      $medication_compound_data[0]['days_supply'] = $days_supply;
      $medication_compound_data[0]['directions'] = $directions;
      $medication_compound_data[0]['dispense_unit_id'] = $DispensUnitId;
      $medication_compound_data[0]['preferred_pharmacy_id'] = $preferred_pharmacy_id;
      $medication_compound_data[0]['no_substitutions'] = $no_substitutions;
      $medication_compound_data[0]['pharmacy_notes'] = $pharmacy_notes;

    }else{
      $days_supply = "30";
      $refills = "0";
      $directions = "Take one at the morning and another before bed";
      //$product_name = "Isotretinoin";
      $no_substitutions = "false";
      $pharmacy_notes =  "";
      $quantity = $accutan_strength;
      $strength = $accutan_strength.'%20mg';

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/medications/select?name='.$removed_space_pro_name.'&strength='.$strength,
        //CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/medications/select?name=ISOtretinoin%20(oral%20-%20capsule)&strength=30%20mg',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $medications = $response;

      $medications = json_decode($medications);

      $DispensUnitId = $medications->dispense_unit_id;
      $dosespot_medication_id = $medications->dosespot_medication_id;

      $medication_compound_data = array();
      $medication_compound_data[0]['dosespot_medication_id'] = $dosespot_medication_id;
      $medication_compound_data[0]['refills'] = $refills;
      $medication_compound_data[0]['quantity'] = $quantity;
      $medication_compound_data[0]['days_supply'] = $days_supply;
      $medication_compound_data[0]['directions'] = $directions;
      $medication_compound_data[0]['dispense_unit_id'] = $DispensUnitId;
      $medication_compound_data[0]['preferred_pharmacy_id'] = $preferred_pharmacy_id;
      $medication_compound_data[0]['no_substitutions'] = $no_substitutions;
      $medication_compound_data[0]['pharmacy_notes'] = $pharmacy_notes;

    }
    $medication_compound_data = json_encode($medication_compound_data);

    $input_md_data = '{"patient_id": '.$patient_id.',"case_files": [],"case_prescriptions": '.$medication_compound_data.',"case_questions": '.$userquestion.'}';


    echo "<pre>";
    print_r($input_md_data);
    echo "<pre>";
    exit();


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "patient_id": '.$patient_id.',
        "case_files": [
        ],
        "case_prescriptions": '.$medication_compound_data.',
        "case_questions": '.$userquestion.'
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$token,
        'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
      ),
    ));

    $response = curl_exec($curl);

    $case_data = json_decode($response);

    $input_data['prioritized_at'] = $case_data->prioritized_at;
    $input_data['prioritized_reason'] = $case_data->prioritized_reason;
    $input_data['cancelled_at'] = $case_data->prioritized_reason;
    $input_data['md_created_at'] = $case_data->created_at;
      //$input_data['md_created_at'] = $case_data->case_assignment->created_at;
    $input_data['support_reason'] = $case_data->support_reason;
    $input_data['case_id'] = $case_data->case_id;
    $input_data['status'] = $case_data->status;
    $input_data['user_id'] = $user_id;
    $input_data['system_case_id'] = $case_id;

    $md_case_data = Mdcases::create($input_data);

    $case_management  =  CaseManagement::where('id',$case_id)->where('user_id',$user_id)->update(['md_case_status' => $case_data->status]);

    curl_close($curl);

      //code for update md details

      /*$inputmd_data['status'] = $status;
      $inputmd_data['image'] = "";
      $inputmd_data['language_id'] = "";
      $inputmd_data['md_id'] = $case_data->case_assignment->clinician->clinician_id;
      $inputmd_data['name'] = $case_data->case_assignment->clinician->full_name;
      $inputmd_data['reason'] = $case_data->case_assignment->reason;;
      $inputmd_data['case_assignment_id'] = $case_data->case_assignment->case_assignment_id;

      $mdmanagement_data = Mdmanagement::where('case_id', $case_id)->first();
      if(!empty($mdmanagement_data)){
        $mdmanagement_data->update($inputmd_data);
      }else{
        $md_case_data = Mdmanagement::create($inputmd_data);
      }*/



      return $response;


    }

    function detach_file_from_case(Request $request){

      $r = get_token();
      $token_data = json_decode($r);
      $token = $token_data->access_token;

      $file_id = $request['md_file_id'];
      $case_id = $request['md_case_id'];

      $destinationPath = public_path('/MD_Case_files');

      $input = $request->all();

      $casefiles_details = CaseFiles::select('*')->where('case_id', $case_id)->where('md_file_id',$file_id)->get();

      if(!empty($casefiles_details) && count($casefiles_details)>0){

        if(file_exists($destinationPath.'/'.$casefiles_details[0]['file'])){
          unlink($destinationPath.'/'.$casefiles_details[0]['file']);
        }

        $casefiles = CaseFiles::find($casefiles_details[0]['id']);
        $casefiles->delete();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/files/'.$file_id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'DELETE',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
            // $response;


        return $this->sendResponse($response,'File Detach Successfully');

      }else{
        return $this->sendResponse(array(),'File not Exist.');
      }


    }

    function getQuestionAnswerFromUserid($user_id,$case_id){

      $answer_data = Answers::where('user_id', $user_id)->where('case_id', $case_id)->get();

      $userQueAns = json_decode($answer_data[0]['answer']);

      return $userQueAns;


    }


    ?>