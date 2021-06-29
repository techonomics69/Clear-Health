<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\Mdpatient;
use Validator;
use Exception;
use App\Models\User;
use App\Models\Mdcases;
use App\Models\Mdmanagement;
use App\Models\CaseFiles;
use App\Models\MdMessages;
use App\Models\MdMessageFiles;
use App\Models\MessageFiles;
use App\Models\Messages;
use App\Models\FollowUp;
use Carbon\Carbon;

class MdwebhooksController extends BaseController
{
   
    public function index(Request $request)
    {
        echo "<pre>";
        print_r('hello');
        echo "<pre>";
        exit();
    }

    public function create()
    {
        //
    }

    public function store()
    {

    }

     public function show()
    {

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

  
 

}