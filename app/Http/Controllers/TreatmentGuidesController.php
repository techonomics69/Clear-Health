<?php

namespace App\Http\Controllers;
    
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;




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
                "detail" => "AAAAAAA",
                "guides_image" => "abcimg",
            ],
            [
                "id" =>"2",
                "title" => "pqr",
                "sub_title" => "pqr1",
                "status" =>"1",
                "detail" => "BBBBBBB",
                "guides_image" => "pqrimg",
            ],
            [
              "id" =>"3",
              "title" => "xyz",
              "sub_title" => "xyz1",
              "status" =>"1",
              "detail" => "CCCCCCCC",
              "guides_image" => "xyzimg",
          ],
          [
              "id" =>"4",
              "title" => "test",
              "sub_title" => "test1",
              "status" =>"1",
              "detail" => "DDDDDDD",
              "guides_image" => "testimg",
          ]);

        return $this->sendResponse($array,'Treatement Guides retrieved successfully.');
    }

    public function show($id)
    {
        $Treatment = array(
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


        //$Treatment = $array::find($id);
        /*echo "<pre>";
        print_r($Treatment);
        echo "</pre>";*/
        //die();

        //$cms = Cms::find($id);
        //foreach ($array as $key => $value) {
           //$product = Product::find($id);
          /*echo $value["id"]."<br />";*/

      //}

      if (is_null($Treatment)) {
        return $this->sendError('Blog not found.');
    }

    return $this->sendResponse($Treatment, 'Cms retrieved successfully.');
}
}