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
            "id" =>"1",
            "title" => "abc",
            "sub_title" => "abc1",
            "status" =>"1",
            "guides_image" => "abcimg",
            );
/*array(
               "id" =>"2",
               "title" => "pqr",
               "sub_title" => "pqr1",
               "status" =>"1",
               "guides_image" => "pqrimg",
            )array(
               "id" =>"3",
               "title" => "xyz",
               "sub_title" => "xyz1",
               "status" =>"1",
               "guides_image" => "xyzimg",
           
            )array(
               "id" =>"4",
               "title" => "rst",
               "sub_title" => "rst1",
               "status" =>"1",
               "guides_image" => "rstimg",
           ));*/

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