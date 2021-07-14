<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use App\Models\CaseManagement;
use App\Models\Mdcases;
use App\Models\User;
use App\Models\Triggers;
use App\Models\Notifications;

class MdwebhooksController extends BaseController
{
	public function index()
	{

	}

	public function show()
	{
       //
	}

	public function store()
	{
       //
	}

	public function webhookTriggers(Request $request){


		$filename = "LOG_" . strtotime(date('Y-m-d H:i:s')) . ".txt";
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/backend/storage/logs/' . $filename, 'w');
		$txt = $response;
		fwrite($file, $txt);
		fclose($file);

		$r = get_token();
    	$token_data = json_decode($r);
    	$token = $token_data->access_token;

    	$postfields = array();

    	if($request['event_type']!=''){
    		$postfields['event_type'] = $request['event_type'];
    	}

    	if($request['case_id']!=''){
    		$postfields['case_id'] = $request['case_id'];
    	}

    	if($request['case_message_id']!=''){
    		$postfields['case_message_id'] = $request['case_message_id'];
    	}

    	 $data = Mdcases::join('users','users.id','=','md_cases.user_id')->where('case_id',$request['case_id'])->select('users.*')->first();

    	 $user_email =  $data['email'];

    	 $user_phone = $data['mobile'];


    	$postdata = json_encode($postfields);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://helloclearhealth.com/backend/api/webhookTriggers',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$postdata,
		  CURLOPT_HTTPHEADER => array(
		    'Signature: xBsQsgLFhYIFNlKwhJW3wClOmNuJ4WQDX0n8475C',
		    'Authorization: Bearer '.$token,
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
	

		

		if(!empty($response)){

		$event = json_decode($response);

		$case_management  =  CaseManagement::where('md_case_id',$event->case_id)->update(['md_case_status' =>$event->event_type]);

		$md_cases  =  Mdcases::where('case_id',$event->case_id)->update(['status' =>$event->event_type]);

		//new message trigger
		if($event->event_type == 'new_case_message'){

			$email_data = array();

			$email_data['email'] = $user_email;
            $email_data['title'] = 'helloclearhealth.com';
            $email_data['body'] = "You have a new message from clinician";
            $email_data['template'] = 'emails.mySendMail';

			$email_sent = sendEmail($email_data);

			/*$smsdata = array();

			$user = array($user_phone);
			$smsdata['users'] = $user;
			$smsdata['body'] = "You have a new message from clinician";
			$sms_sent = sendsms($smsdata);*/
		}
		//end of new message 

		 $noti_input_data = array();
         $noti_input_data['user_id'] = $user_id;
         //$noti_input_data['case_id'] = $case_id;
         $noti_input_data['md_case_id'] = $event->case_id;

         $noti_input_data['noti_message'] = getNotificationMessageFromKey('message_from_md');
         //$noti_input_data['for_month'] = $follow_up;

         $noti_data = Notifications::create($noti_input_data);

          

		}


	}
}