<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;
use Exception;



   
class TreatmentGuidesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*$array = array(
    "foo" => "bar",
    "bar" => "foo",
);

// Using the short array syntax
$array = [
    "foo" => "bar",
    "bar" => "foo",
];
   */ 
$test ="hello 1";
   echo $test;   
    
        return $this->sendResponse($test,'Cms retrieved successfully.');
    }

    /*public function show($id)
    {
        $cms = Cms::find($id);
  
        if (is_null($cms)) {
            return $this->sendError('Blog not found.');
        }
   
        return $this->sendResponse($cms, 'Cms retrieved successfully.');
    }*/
}