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
            [
                "id" =>"1",
                "title" => "abc",
                "sub_title" => "abc1",
                "status" =>"1",
                "guides_image" => "abcimg",
            ],
            [
                "id" =>"2",
                "title" => "pqr",
                "sub_title" => "pqr1",
                "status" =>"1",
                "guides_image" => "pqrimg",
            ],
            [
              "id" =>"3",
              "title" => "xyz",
              "sub_title" => "xyz1",
              "status" =>"1",
              "guides_image" => "xyzimg",
          ],
          [
              "id" =>"4",
              "title" => "test",
              "sub_title" => "test1",
              "status" =>"1",
              "guides_image" => "testimg",
          ]);

        return $this->sendResponse($array,'Treatement Guides retrieved successfully.');
    }

    public function show($id)
    {
        $array = array(
            [
                "id" =>"1",
                "title" => "abc",
                "sub_title" => "abc1",
                "status" =>"1",
                "guides_image" => "abcimg",
            ],
            [
                "id" =>"2",
                "title" => "pqr",
                "sub_title" => "pqr1",
                "status" =>"1",
                "guides_image" => "pqrimg",
            ],
            [
              "id" =>"3",
              "title" => "xyz",
              "sub_title" => "xyz1",
              "status" =>"1",
              "guides_image" => "xyzimg",
          ],
          [
              "id" =>"4",
              "title" => "test",
              "sub_title" => "test1",
              "status" =>"1",
              "guides_image" => "testimg",
          ]);
  

//$products = Product::where('product_active', '1')->get();
         foreach ($array as $key => $value) {
           //$product = Product::find($id);
           $value->arrau = $value->id; 
        }

        if (is_null($array)) {
            return $this->sendError('Blog not found.');
        }
   
        return $this->sendResponse($array, 'Cms retrieved successfully.');
    }
}