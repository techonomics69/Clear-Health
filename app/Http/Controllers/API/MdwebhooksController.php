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

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://103.101.59.95/dev.clearhealth/api/webhookTriggers',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"event_type": "case_processing",
				"case_id": "a291868a-1e93-4de6-9a33-932f4b885fb9"
			}',
			CURLOPT_HTTPHEADER => array(
				'Signature: 9Z40wLrAPkEFEmAp0eh0aLfStXUya86D2un1iuhy',
				'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJjN2EyMGE5MC00ZGI5LTQyZTQtODYwYS03ZjQxYzJhOGEwYjEiLCJqdGkiOiIwZmM1YWRhMzc5YjNjZjhhOTA2ZDU5ZDI4NDIwNmQ1NDRlMTAxYmQyNTMzY2YxZGY1YmFlYmExZDUxYmIwYWNlNTI3NzQ4MDE0OTU4NGVmOSIsImlhdCI6MTYyNDk2MzYzOC4xMzcwNzQsIm5iZiI6MTYyNDk2MzYzOC4xMzcwNzYsImV4cCI6MTYyNTA1MDAzOC4xMjk3NTcsInN1YiI6IiIsInNjb3BlcyI6WyIqIl19.Fdh4CMnmeVoyRR4-AdTABlN0-Lbia-GdNybZ8fx7owuf-Dz-WZJ1-8KuUo4h57ZSwIHjIGvuS6mZPWpcJsfrQQl_2HT_6JjfxLLIynrQAUfnGy5-Iacdxjb2WdA2jucScxf1oegxMBsr312afYD-vLZpVAD8fueuE35SWNxZa7wGMlACH-s0o_cPFtVV0n-f87D-hfZcVpwezg7luKrZCnXnvXh2AFECHiWQpCeKG78QqnfiWGccCXcsPMFKp1Q7RIEMeNq-X_piadgMOYC1inL5cRLWXNmS3KYXV_Z_bFU1UuKL93NpAsGbTi63KAUl-G9yyt2RG-RlYMUO9GzoXdvpv6naOZmGP_itM4FKkmsj4bru-orEmOqtOXBIIa7GYRXhrIGi0R_WKnntb2ws03jRcB49POo6pQ2_Dzt1qEGQ1Itp71G8kmIxG8u6AOcJDvjQM7mNVOCYVA-x-0encEHF_B__7dxTq74UCREyAn1YOIPpuJlNNMxffwobyR50MJohTdIGBXLoDVGnHsj-NKWgeeeL4EjEonjvTOdMWH-zroDBR7heXdz9-3CBiINHjLNcGcA1ptO9lSa29ahVCEGaGMiUClNk5BZ0EPNu_hMYYemoCz9h2ZgPI3a0gT_Yz5jnbOESYQbRAKMzgVI7PPAK69ADT3QTalQnkaBDNwY'
				//'Authorization: '.$token,
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

	}
}