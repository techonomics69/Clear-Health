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

		echo "hello";

	}
}