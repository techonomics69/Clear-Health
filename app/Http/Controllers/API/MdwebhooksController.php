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

    	echo "<pre>";
    	print_r($request->all());
    	echo "<pre>";
    	exit();

    }
}