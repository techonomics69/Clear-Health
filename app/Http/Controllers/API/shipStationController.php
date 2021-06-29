<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Helper\shipStationHelper;

class shipStationController extends BaseController
{
    public function getOrderDetails(Request $request){
        $orderData = shipStationHelper::getOrderData($request['orderId']);
        return $this->sendResponse($orderData,'Order Details');
    }

    

}
