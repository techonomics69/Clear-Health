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

function create_patient(Request $request)
{
	$r = $this->get_token();
	$token_data = json_decode($r);

	$token = $token_data->access_token;

	$input = json_encode($request->all());

	$input_data = $request->all();

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
      {*/
      	return $this->sendResponse($input_data,'Patient Created Successfully'); 
     //}

      }else{
      	return $this->sendResponse(array(),'Something went wrong!');
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


?>