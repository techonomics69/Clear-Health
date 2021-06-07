<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\TreatmentGuides;

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

      $TreatmentGuides = TreatmentGuides::where('status', 1)->get();
        return $this->sendResponse($TreatmentGuides,'Treatement Guides retrieved successfully.');
    }

    public function show($id)
    {
        $TreatmentGuides = TreatmentGuides::find($id);
  
        if (is_null($TreatmentGuides)) {
            return $this->sendError('Treatment Guides not found.');
        }
   
        return $this->sendResponse($TreatmentGuides, 'Treatment Guides retrieved successfully.');
}
}