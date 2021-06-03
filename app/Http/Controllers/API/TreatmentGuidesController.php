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

        $array = array(
    "title" => "test",
    "sub_title" => "test1",
    "status" =>"1",
    "img" => "test",
        );
        $array1 = array(
    "title" => "test",
    "sub_title" => "test1",
    "status" =>"1",
    "img" => "test",
        );
        $array2 = array(
    "title" => "test",
    "sub_title" => "test1",
    "status" =>"1",
    "img" => "test",
        );

// Using the short array syntax

        return $this->sendResponse($array,'Cms retrieved successfully.');
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