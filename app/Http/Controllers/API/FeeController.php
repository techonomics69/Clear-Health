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
        $fees = Fees::where('status','1')->where('fee_type',$fee_type)->get();

        $total_amount = 0;
        foreach( $fees as $key=>$fee){
            $total_amount += $fee['amount'];
        }

        $fees['fee_total_amount'] = $total_amount;
        $fees['fee_type'] = $fee_type;
        $product_type['product_type'] = 'Prescribed';

        if($product_type == "Non Prescribed")
        {
            if($total_amount >30)
            {
                echo "Free shiping";
            }
            else{
                echo "charge";
            }
            else
            {
                echo "test";
            }
        }

        return $this->sendResponse($fees,'Fees Retrived successfully');
    }
}