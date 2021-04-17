<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\Mdpatient;
use Validator;
use Exception;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function demo()
    {

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://103.101.59.95/dev.clearhealth/api/create_patient',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "first_name": "testphp111111",
    "last_name": "Doe1111",
    "gender": 1,
    "date_of_birth": "2000-12-31",
    "phone_number": "541-754-3011",
    "phone_type": 2,
    "email": "testp11hp111111@gmail.com",
    "address": {
        "address": "1901 1st Avenue, New York, NY 10029",
        "city_id": "0b56b7a1-dae8-4bf8-a44f-4cb808115a6c",
        "zip_code": "12345"
    },
    "weight": 50,
    "height": 180
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJjN2EyMGE5MC00ZGI5LTQyZTQtODYwYS03ZjQxYzJhOGEwYjEiLCJqdGkiOiI0MzBhNDI1YmYxNTlhNjlkMzk4YmVmYzRjYjAxOWY2YmZkZjljZWI3ZWI1NmRhM2Q3MTk5ZWQxMDg2MzJkNjk3NGEwNmY4ZDlkZWE3OTE0OSIsImlhdCI6MTYxODMxNDI2NC4wMjgzOTgsIm5iZiI6MTYxODMxNDI2NC4wMjg0MDEsImV4cCI6MTYxODQwMDY2NC4wMjI3ODgsInN1YiI6IiIsInNjb3BlcyI6WyIqIl19.kT6nb2qeI9dM9hLFjpc4Ct3h6xMtpAi4B-1iNVKwNfZ2tCsAV8NwInl44rkTSLujquKPUc3_pAK7smJ-R5tlV1rc_9t7gXsAoRMxiXGiub4UXl4pBNtt95PcxpDLmB9y8mGHLwqgkDy0cabn1x-baf8VBVtaxDMxMWQvlQYmL8X3kdw6QQzgYX45WOqxsyS9JqNml4bn_hGZaG-MGvXtPswaFiKs3YqZHKNeGqnbr4KX-Q6gm2X8loCMOZItPBV2XjVor4bLgxd3AkLWIqBSdhjpwiqRNXDVjdSdIvgFuxpzPZq6K3y_OhHNQluKbCVEhob-YVweikQR1k2pK6UycLrvkFhICSsYiay8qYkdpbpdwDOK7ZtfDGPX070xUWzSlP_vrIvLndsCbucQSFYeelQa_P1aw5ma-35AraN9Ove5eEzetRlvUis_dZNdKDMl2NlAltv9FTsssSQ94rD0tVeW8omkXoA2w9QhtSt-MrB_loqkKt7aExfh5mTeW5I7qhuiz3Row66Z-mizh9BXeCR-JqjcF7qUKW4oQ6qOoAX859YQj_5BEL3rxEz6Xcupr3dEIKtfAGg5Oeeb3J25DDU7QemTEyp4v46Gkc_DFI8zl6HxOg7zcPhH5WXEP6SsUWBAcFIZ8zZg2_fAF_qOAjG1wEqdX1T1C9-Ng517E9U',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

    }

    
    public function get_token(){
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



     public function create_patient(Request $request)
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

     /* echo "<pre>";
      print_r( $response);
      echo "<pre>";*/
     

      $Patient_data = json_decode($response);

       /*echo "<pre>";
      print_r( $response);
      echo "<pre>";
    */
       $input_data['partner_id'] = '45af5944-4ad1-4269-b2b2-a2d4164e591d';//$Patient_data['partner_id'];
       $input_data['first_name'] = 'Greha';//$Patient_data['first_name'];
       $input_data['last_name'] = 'Thomas';//$Patient_data['last_name'];
       $input_data['email'] = 'grethoms@gmail.com';//$Patient_data['email'];
       $input_data['gender'] = 0 ;//$Patient_data['gender'];
       $input_data['phone_number'] = '812-349-9879';//$Patient_data['phone_number'];
       $input_data['phone_type'] = 2;//$Patient_data['phone_type'];
       $input_data['date_of_birth'] = '2000-12-11';//$Patient_data['date_of_birth'];
       $input_data['active'] = 1;//$Patient_data['active'];
       $input_data['weight'] = 60;//$Patient_data['weight'];
       $input_data['height'] = 190;//$Patient_data['height'];
       $input_data['dosespot_sync_status'] = 'pending';//$Patient_data['dosespot_sync_status'];
       $input_data['patient_id'] = '755b8cd2-9abd-4016-b76f-f23f44d75e20';//$Patient_data['patient_id'];
       $input_data['gender_label'] = 'Male';//$Patient_data['gender_label'];
       $input_data['address'] = '1901 1st Avenue, New York, NY 10029';//$Patient_data['address']->address;
       $input_data['zip_code'] = '34535';//$Patient_data['address']->zip_code;
       $input_data['city_id'] = '0b56b7a1-dae8-4bf8-a44f-4cb808115a6c';//$Patient_data['address']->city_id;
       $input_data['city_name'] = 'Lake California';//$Patient_data['address']['city']->name;
       $input_data['state_name'] = 'California';//$Patient_data['address']['city']->state->name;
       $input_data['state_abbreviation'] = 'CA';//$Patient_data['address']['city']->state->abbreviation;


      /* echo "<pre>";
       print_r($input_data);
       echo "<pre>";
       exit();*/
      
      $md_patient_data = Mdpatient::create($input_data);

            //$info = curl_getinfo($curl);

      if(curl_exec($curl) == false)
      {
        echo 'Curl error: ' . curl_error($curl);
              //return $this->sendResponse($response, 'Patient Created Successfully1'); 
      }
      else
      {
       return $this->sendResponse($response,$input_data,'Patient Created Successfully'); 
     }
   }

}
