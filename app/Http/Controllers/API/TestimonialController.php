<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Testimonial;
use Validator;

   
class TestimonialController extends BaseController
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial = Testimonial::all();
    
        return $this->sendResponse($testimonial, 'Testimonial retrieved successfully.');
    }

    public function show($id)
    {
        $testimonial = Testimonial::find($id);
  
        if (is_null($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }
   
        return $this->sendResponse($testimonial, 'Testimonial retrieved successfully.');
    }
}