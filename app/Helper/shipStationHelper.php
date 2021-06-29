<?php
namespace App\Helper;
use GuzzleHttp\Guzzle;
use LaravelShipStation;
use LaravelShipStation\ShipStation;
use Illuminate\Support\Facades\App;

class shipStationHelper {

    public static function InitializeHelper(){
        $app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
        $testm = "hello";
    }
        
    public static function createOrder($orderData){
        $InitializeHelper = $this->InitializeHelper();
        return (isset($testm)) ? $testm : 'none';
    }

    public static function getOrderData($orderId){
        
    }

}

?>