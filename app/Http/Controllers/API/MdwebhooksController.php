<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

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


    	echo "<pre>";
    	print_r(json_encode($postfields));
    	echo "<pre>";
    	exit();

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://your.api.endpoint/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"event_type": "new_case_message",
			"case_id": "26f3d453-09ff-41cb-9fc6-724d1b77277c",
			"case_message_id": "26f3d453-09ff-41cb-9fc6-724d1b77277c"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Signature: <Your Secret Key>',
		    'Authorization: Barer '.$token,
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;


	}
}