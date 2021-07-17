<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Offers;
use App\Models\Userpromocode;
use Validator;
use \Carbon\Carbon;
   
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

     public function applyGiftCard(Request $request){        
        $offer = Offers::where('promocode', $request->code)->first();

        if(isset($offer) && !empty($offer)){

            $userpromocode = Userpromocode::where('promocode', $request->code)->first();

            if(isset($userpromocode) && !empty($userpromocode)){
               return $this->sendResponse(false,'Already used this Gift card code'); 
           }
           else{
               $date = Carbon::now();
               $cuurentDate = $date->format('Y-m-d');

               if(($offer->from_date <= $cuurentDate) && ($offer->to_date >= $cuurentDate)){              
                return $this->sendResponse($offer, 'Offers retrieved successfully.'); 
                }else{                 
                return $this->sendResponse(false,'Invalid Gift card code'); 
                }
            }

        }else{
            return $this->sendResponse(false, 'Invalid Gift card code'); 
        }       
   }
}