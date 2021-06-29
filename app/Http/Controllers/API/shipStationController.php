<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\shipStationHelper;

class shipStationController extends Controller
{
    public function getOrderDetails(Request $request){
        $orderData = shipStationHelper::getOrderData($request['orderId']);
        return $this->sendResponse($orderData,'Order Details');
    }
}
