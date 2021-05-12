<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Fees;
use Validator;


class FeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category)
    {

    }

    public function getFees(Request $request){
        $fee_type = $request->fee_type;
        $fee_amount = $request->amount;
        $fees = Fees::where('status','1')->where('fee_type',$fee_type)->get();
        $minimum_shipping_amount = Fees::where('status','1')->where('fee_type','minimum_shipping_amount')->get();
        echo $fee_amount.'00000';
        die();
        $total_amount = 0;
        foreach( $fees as $key=>$fee){
            $total_amount += $fee['amount'];
        }

        $fees['fee_total_amount'] = $total_amount;

        if($product_type == "Non Prescribed")
        {
            if($fee_amount > $minimum_shipping_amount)
            {
                $shiping_fee=0;
            }
            else{
                $shipping_fee = Fees::where('status','1')->where('fee_type','shipping_fee')->get();
            }
        }
        else{

        }

        $fees['shiping_fee'] = $shiping_fee;
        $fees['minimum_shipping_amount'] = $minimum_shipping_amount;

        return $this->sendResponse($fees,'Fees Retrived successfully');
    }
}