<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Offers;
use Validator;

   
class OfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $data = Offers::orderBy('id','DESC')->get();
    
        return $this->sendResponse($data, 'Offers retrieved successfully.');
    }

    public function show($id)
    {
        
    }
}