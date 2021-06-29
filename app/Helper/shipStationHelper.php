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
        $InitializeHelper = shipStationHelper::InitializeHelper();

        $address = new LaravelShipStation\Models\Address();
	    
        $address->name = $orderData['patient_firstname']." ".$orderData['patient_lastname'];
	    $address->street1 = $orderData['addressline1']." ".$orderData['addressline2'];
	    $address->city = $orderData['city'];
	    $address->state = $orderData['state'];
	    $address->postalCode = $orderData['zipcode'];
	    $address->country = "US";
	    $address->phone = $orderData['phone'];

        $products = $orderData['cart_id'];

        

        // $item = new LaravelShipStation\Models\OrderItem();

	    // $item->lineItemKey = '1';
	    // $item->sku = '580123456';
	    // $item->name = "Awesome sweater.";
	    // $item->quantity = '1';
	    // $item->unitPrice  = '29.99';
	    // $item->warehouseLocation = 'Warehouse A';

        // $order = new LaravelShipStation\Models\Order();
	    // $order->orderNumber = $orderData['order_id'];
	    // $order->orderDate = date("Y-m-d");
	    // $order->orderStatus = 'awaiting_shipment';
	    // $order->amountPaid = $orderData['total_amount'];
	    // $order->taxAmount = $orderData['tax'];
	    // $order->shippingAmount = $orderData['shipping_fee'];
	    // $order->internalNotes = '';
	    // $order->billTo = $address;
    	// $order->shipTo = $address;
    	// $order->items[] = $item;

        return (isset($testm)) ? $testm : 'none';
    }

    public static function getOrderData($orderId){
        
    }

}

?>