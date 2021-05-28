<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\Mdpatient;
use Validator;
use Exception;
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
use File;

class CaseManagementController extends BaseController
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
    public function store(Request $request)
    {
      $data = $request->all();
      $case = CaseManagement::OrderBy('id','desc')->first();
      $query = 'insert';
      if(!empty($data['user_id'])):
        $caseUser = CaseManagement::where('user_id', $data['user_id'])->OrderBy('id','desc')->first();
        if(!empty($caseUser)):
          if($caseUser->case_status != 'completed'):            
            $query = 'update';
          endif;
        endif;
      endif;

      if($query == 'insert'):
        if(!empty($case)):
          $year = substr($case->ref_id, 3, -9);
          $current_year = date("Y");
          if(!empty($case->ref_id) && ($year == $current_year)):
            $id = number_format(substr($case->ref_id, 8)) + 1;
          $ref_number = str_pad($id,8,'0',STR_PAD_LEFT);
        endif;
      else:
        $ref_number = "00000001";
      endif;
      $ref_id = "CH-".date("Y")."-".$ref_number;
      $data['ref_id'] = $ref_id;

      if(empty($data['user_id'])):
        if(isset($data['token']) && !empty($data['token'])):

          $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

      endif;  
    endif;     
    try{
      $validator = Validator::make($data, [
        'user_id' => 'required',
      ]);
      if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors()->all());       
      }
      $quizAns = CaseManagement::create($data);

      return $this->sendResponse($data, 'Case Created Successfully');
    }catch(\Exception $ex){
      return $this->sendError('Server error',array($ex->getMessage()));
    }
  else:                               
    try{    

      if($data['case_status'] == '/zipcode'):
        unset($data['case_status']);
      endif;
      $sendData = CaseManagement::where('user_id', $data['user_id'])->OrderBy('id','desc')->first();           
      if(!empty($caseUser)):
        $caseUpdate = $caseUser->update($data);
      else:
        return $this->sendError('Server error', array('Case Not Found'));
      endif;

      return $this->sendResponse($sendData, 'Case Updated Successfully');
    }catch(\Exception $ex){
      return $this->sendError('Server error',array($ex->getMessage()));
    }
  endif;

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try{ 
        $caseUser = CaseManagement::where('user_id', $id)->OrderBy('id','desc')->first();
        if(is_null($caseUser)):
          return $this->sendError('Server error', array('Case Not Found'));
        else:
          return $this->sendResponse($caseUser, 'Data recieved Successfully');
        endif;            
      }catch(\Exception $ex){
        return $this->sendError('Server error',array($ex->getMessage()));
      }
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

    public function add_recomeended_product(Request $request)
    {
      $user_id = $request['user_id'];
      $case_id = $request['case_id'];
      $recommended_product = $request['recommended_product'];

      $data  =  CaseManagement::where('user_id',$user_id)->where('id',$case_id)->update(['recommended_product' => $recommended_product]);

      if($data!= 1){
       return $this->sendError('Server error', array('Something went wrong!'));
     }
     else{
      return $this->sendResponse($data, 'Recomended product added successfully');
    }

  }


public function create_patient(Request $request)
{
  create_patient();
}

  public function searchStateDetail(Request $request){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $search = $request['search_state'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/metadata/states?search='.$search,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: '.$token,
        'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $this->sendResponse(json_decode($response),'State data recieved successfully');
  }

  public function getAllStates(){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/metadata/states',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: '.$token,
        'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;

    return $this->sendResponse(json_decode($response),'State data recieved successfully');
  }


  public function SearchCitiesFromGivenState(Request $request){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;



    $state_id = $request['state_id'];
    $search_city = $request['search_city'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/metadata/states/'.$state_id.'/cities?search='.$search_city,
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
    //echo $response;

    return $this->sendResponse(json_decode($response),'City data recieved successfully');

  }

  public function getCitiesFromGivenState(Request $request){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $state_id = $request['state_id'];
    //$search_city = $request['search_city'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/metadata/states/'.$state_id.'/cities',
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
    //echo $response;

    return $this->sendResponse(json_decode($response),'City data recieved successfully');

  }

  public function createCaseFile(Request $request){

    $r = get_token();
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

  public function getPharmacies(Request $request){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $search = "";
    $zip = $request['zipcode'];
    $address = $request['address'];

    if($zip!="" && $address == ""){
     $search = "?zip=".$zip;

   }else if($address!="" && $zip ==""){
    $search = "?address=".urlencode($address);

  }else if($zip!="" && $address != ""){
    $zip = $request['zipcode'];
    $address = $request['address'];
    $search = "?zip=".$zip."&address=".urlencode($address);
  }else{
    $search = "";
  }


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/pharmacies'.$search,
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
  return $this->sendResponse(json_decode($response),'Pharmacies Recieved Successfully');


}


public function getPharmacyById(Request $request){
  $r = get_token();
  $token_data = json_decode($r);
  $token = $token_data->access_token;

  $pharmacy_id = $request['pharmacy_id'];

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


  return $this->sendResponse(json_decode($response),'Pharmacy Recieved Successfully');


}


public function CreateCase(Request $request){
  $r = get_token();
  $token_data = json_decode($r);
  $token = $token_data->access_token;

  $user_id = $request['user_id'];
  $case_id = $request['case_id'];

  $product_type = $request['product_type'];
  //$product_name = $request['product_name'];
  //$quantity = $request['quantity'];
  $preferred_pharmacy_id = $request['preferred_pharmacy_id'];

  $patient_data = User::select('md_patient_id')->where('id', $request['user_id'])->first();

  $patient_id = '"'.$patient_data['md_patient_id'].'"';

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


   $answer_data = Answers::where('user_id', $user_id)->where('case_id', $case_id)->get();

   $userQueAns = json_decode($answer_data[0]['answer']);

 //get weight of patient 

   //$answer = QuizAnswer::join('quizzes', 'quizzes.id', '=', 'quiz_answers.question_id')->where('quiz_answers.user_id', $request['user_id'])->where('quiz_answers.case_id', $request['case_id'])->where('quiz_answers.case_id', $request['case_id'])->select( 'quizzes.question','quiz_answers.answer','quizzes.options_type')->get()->toArray();
   $accutan_strength = 30;
   foreach ($userQueAns as $key => $value) {

    $question = $value->question;

    if($question == "What is your weight in kg?"){
      if(isset($value->answer) && $value->answer!=''){

        $answer =  $value->answer;

        if($answer >= 70){
          $accutan_strength = 40;
        }else{
          $accutan_strength = 30;
        }   
      }
    }
  }
//end of code to get patient weight 
  $userquestion = array();
  foreach($userQueAns as $key=>$value){

    if(isset($value->answer) && $value->answer!=''){
      $userquestion[$key]['question'] = $value->question;

      if(is_array($value->answer)){
         $userquestion[$key]['answer'] = implode(',',$value->answer);
      }else{
         $userquestion[$key]['answer'] = $value->answer;
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



 if($product_type =="Topicals"){

  $days_supply = "60";
  $refills = "11";
  $directions = "Take one at the morning and another before bed";
  $no_substitutions = "true";
  $pharmacy_notes =  "This medication might not be suitable for people with... ";
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
      //$medication_compound_data[0]['no_substitutions'] = $no_substitutions;
      //$medication_compound_data[0]['pharmacy_notes'] = $pharmacy_notes;

    }else{
      $days_supply = "30";
      $refills = "0";
      $directions = "Take one at the morning and another before bed";
      //$product_name = "Isotretinoin";
      $no_substitutions = "true";
      $pharmacy_notes =  "This medication might not be suitable for people with... ";
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
      //$medication_compound_data[0]['no_substitutions'] = $no_substitutions;
      //$medication_compound_data[0]['pharmacy_notes'] = $pharmacy_notes;

    }
    $medication_compound_data = json_encode($medication_compound_data);

    /*$input_md_data = '{"patient_id": '.$patient_id.',"case_files": [],"case_prescriptions": '.$medication_compound_data.',"case_questions": '.$userquestion.'}';*/

   /* echo "<pre>";
    print_r($input_md_data);
    echo "<pre>";
    exit();*/

      

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



      return $this->sendResponse(json_decode($response),'Case Created Successfully');


}

  /*public function getDispensUnitId(){

    $r = $this->get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/dispense-units?name=kit',
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
    return $response;


  }*/

  public function getMdDetails(Request $request){

    /*$r = $this->get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;*/


    $md_id = $request['md_id'];
    $case_id = $request['case_id'];
    $name = $request['name'];
    $status = 1;

    $input = $request->all();
    $input['status'] = $status;
    $input['image'] = "";
    $input['language_id'] = "";

    $mdmanagement_data = Mdmanagement::where('case_id', $case_id)->first();
    if(!empty($mdmanagement_data)){
      $mdmanagement_data->update($input);
    }else{
      $md_case_data = Mdmanagement::create($input);
    }

    return $this->sendResponse($input,'MD Details Added Successfully');
    

  }


public function detach_file_from_case(Request $request){

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

  public function createMessageFile(Request $request){
    $r = get_token();
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
      
      if (!file_exists(public_path('/Message_files'))) {
        File::makeDirectory(public_path('/Message_files'),0777,true,true);
      }
      $destinationPath = public_path('/Message_files');
      $documents->move($destinationPath, $doc_file_name);

      chmod($destinationPath."/".$doc_file_name, 0777);

      $file_path = 'public/Message_files/' .$file;
    }

    $input_data = $request->all();

    $fields = [
      'name' => $name,
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

    $message_file_data = json_decode($response);
    $input_data = array();

    $input_data['md_case_id'] = $case_id;
    $input_data['system_file'] = $file_path;
    $input_data['user_id'] = $user_id;
    $input_data['case_id'] = $system_case_id;
    $input_data['name'] = $message_file_data->name;
    $input_data['mime_type'] = $message_file_data->mime_type;
    $input_data['url'] = $message_file_data->url;
    $input_data['url_thumbnail'] = $message_file_data->url_thumbnail;
    $input_data['file_id'] = $message_file_data->file_id;

    $message_file_data = MdMessageFiles::create($input_data);

    return $this->sendResponse($message_file_data,'File created successfully');

  }

  public function createMessage(Request $request){
    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $user_id = $request['user_id'];
    $case_id = $request['case_id'];
    $system_case_id = $request['system_case_id'];

    //code to get files ids
    $file_ids = MdMessageFiles::where('user_id', $user_id)->where('md_case_id', $case_id  )->pluck('file_id');

    if(!empty($file_ids) && count($file_ids)){
      $file_ids = $file_ids;
    }else{
      $file_ids = array();
    }
    // end of code to get files ids

    $postfields = array();
    $postfields['from'] = $request['from'];
    $postfields['text'] = $request['text']; 
    $postfields['prioritized'] = $request['prioritized']; 
    $postfields['prioritized_reason'] = $request['prioritized_reason'];
    $postfields['message_files'] = $file_ids;

    $postfields = json_encode($postfields);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/messages',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$postfields,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$token,
        'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $message_data = json_decode($response);
    $input_data = array();

    $input_data['md_case_id'] = $case_id;
    $input_data['user_id'] = $user_id;
    $input_data['case_id'] = $system_case_id;
    $input_data['text'] = $message_data->text;
    $input_data['from'] = $message_data->from;
    $input_data['channel'] = $message_data->channel;
    $input_data['prioritized_at'] = $message_data->prioritized_at;
    $input_data['prioritized_reason'] = $message_data->prioritized_reason;
    $input_data['message_created_at'] = $message_data->created_at;
    $input_data['case_message_id'] = $message_data->case_message_id;
    //$input_data['message_files_ids'] = json_encode($file_ids);
    $input_data['clinician  '] = $message_data->clinician ;
    $message_data = MdMessages::create($input_data);

    return $this->sendResponse($message_data,'Message created successfully');

   
  }

  public function setMessageAsRead(Request $request){

    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $case_id = $request['case_id'];
    $case_message_id = $request['case_message_id'];


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/messages/'.$case_message_id.'/read',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token,
        'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $data = json_decode($response);

    //$MdMessages = MdMessages::where('md_case_id',$case_id)->where('case_message_id',$case_message_id)->get();


    $read_at = $data->read_at;


    //$caseUpdate = $MdMessages->update($read_at);

    $caseUpdate  =  MdMessages::where('md_case_id',$case_id)->where('case_message_id',$case_message_id)->update(['read_at' => $read_at]);

    if($caseUpdate == 1){
      return $this->sendResponse($data,'Message created successfully');
    }else{
      return $this->sendResponse(array(),'Something went wrong');
    }

  }
 
  public function getMessages(Request $request){

    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $case_id = $request['case_id'];
    //$case_message_id = $request['system_case_id'];
    $channel = $request['channel'];



    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/messages?channel='.$channel,
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
    
    $data = json_decode($response);

    if(!empty($data) && count($data)>0 ){
      return $this->sendResponse($data,'Message retrieved successfully');
    }else{
      return $this->sendResponse(array(),'No data found');
    }



  }

  public function DetachMessageFile(Request $request){

    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $case_id = $request['case_id'];
    $case_message_id = $request['case_message_id'];
    $file_id = $request['file_id'];
    $user_id = $request['user_id'];
    $system_case_id = $request['system_case_id'];


    $destinationPath = public_path('/Message_files');

    $input = $request->all();

    $messagefiles_details = MdMessageFiles::select('*')->where([['case_id', '=', $system_case_id],['md_case_id', '=', $case_id],['user_id', '=',$user_id],['file_id', '=',$file_id]])->first();

    $file_name = str_replace("public/Message_files/","",$messagefiles_details['system_file']);
    
    $delete_file = $this->DeleteFile($file_id);


    $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/messages/'.$case_message_id .'/files/'.$file_id,
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


       if(!empty($messagefiles_details)){

      if(file_exists($destinationPath.'/'.$file_name)){
        unlink($destinationPath.'/'.$file_name);
      }

      $messagefiles = MdMessageFiles::find($messagefiles_details['id']);
      $messagefiles->delete();

      return $this->sendResponse($response,'File Detach Successfully');
    }
    else{
      return $this->sendResponse(array(),'File not Exist.');
    }
 

  }

  public function DeleteFile($file_id){

    $r = get_token();
    $token_data = json_decode($r);
    $token = $token_data->access_token;

    $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/files/'.$file_id,
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

      return $response;

  }


  public function sendMessageNonMedical(Request $request){
    $user_id = $request['user_id'];
    $case_id = $request['md_case_id'];
    $system_case_id = $request['case_id'];
    $users_message_type = $request['users_message_type'];//medical/non_medical
    $sender = $request['sender'];//user/admin
    $text = $request['text']; 

    //code to upload files ids
     $documents = $request->file('file');

     if(!empty($documents)){
      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time().'-'.$file;
      
      if (!file_exists(public_path('/Message_files'))) {
        File::makeDirectory(public_path('/Message_files'),0777,true,true);
      }
      $destinationPath = public_path('/Message_files');
      $documents->move($destinationPath, $doc_file_name);

      chmod($destinationPath."/".$doc_file_name, 0777);

      $file_path = 'public/Message_files/' .$file;
    }else{
      $file = "";
      $file_path="";
    }
    // end of code to upload files ids
    
    $input_data = array();

    $input_data['md_case_id'] = $case_id;
    $input_data['user_id'] = $user_id;
    $input_data['case_id'] = $system_case_id;
    $input_data['text'] = $text;
    $input_data['users_message_type'] = $users_message_type;
    $input_data['sender'] = $sender;
    $message_data = Messages::create($input_data);

    $message_file_data = array();
    $message_file_data['file_name'] = $file;
    $message_file_data['file_path'] = $file_path;
    $message_file_data['msg_id'] = $message_data['id'];
    $message_file_data = MessageFiles::create($message_file_data);
    if(!empty($message_file_data)){
      $message_data['file_name'] = $file;
      $message_data['file_path'] = $file_path;
    }

    return $this->sendResponse($message_data,'Message created successfully');

  }

  public function getMessagesNonMedical(Request $request){
    $case_id = $request['case_id'];
    $user_id = $request['user_id'];
    $md_case_id = $request['md_case_id'];

    $message_details = Messages::join('message_files', 'messages.id', '=', 'message_files.msg_id')->select('messages.*','message_files.*')->where('case_id', $case_id)->where('md_case_id',$md_case_id)->where('user_id',$user_id)->get();

    if(!empty($message_details) && count($message_details)>0 ){
      return $this->sendResponse($message_details,'Message retrieved successfully');
    }else{
      return $this->sendResponse(array(),'No data found');
    }



  }


}