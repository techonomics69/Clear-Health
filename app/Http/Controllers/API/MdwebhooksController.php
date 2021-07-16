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

	public function webhookTriggers(){

		$response = "this is the log file";

		$filename = "LOG_" . strtotime(date('Y-m-d H:i:s')) . ".txt";
		//$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/backend/storage/logs/' . $filename, 'w');
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/dev.clearhealth/storage/logs/' . $filename, 'w');
		$txt = $response;
		fwrite($file, $txt);
		fclose($file);
	}
}