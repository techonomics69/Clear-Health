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
        //$order_total_amount = $request->order_total_amount;
        //$product_type = $request->product_type;
        $fees = Fees::where('status','1')->where('fee_type',$fee_type)->first();

        //$minimum_shipping_amount = Fees::where('status','1')->where('fee_type','minimum_shipping_amount')->get();

        $total_amount = 0;

        foreach( $fees as $key=>$fee){
            $total_amount += $fee['amount'];
        }

        $fees['fee_total_amount'] = $total_amount;

        /*if($product_type == "Non Prescribed")
        {
            if($order_total_amount > $minimum_shipping_amount[0]['amount'])
            {
                $shipping_fee = 0;
            }
            else
            {
                $shipping_fee = Fees::where('status','1')->where('fee_type','shipping_fee')->get();
                $shipping_fee = $shipping_fee[0]['amount'];
            }

        }*/
       /* $fees['shipping_fee'] = $shipping_fee;
        $fees['minimum_shipping_amount'] = $minimum_shipping_amount[0]['amount'];*/

        return $this->sendResponse($fees,'Fees Retrived successfully');
    }
}