<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\shipStationHelper;

class shipStationController extends Controller
{
    public function getShiprates(Request $request){
        $getRates = shipStationHelper::getRates($request->all());
        return $getRates;
    }

    
}
