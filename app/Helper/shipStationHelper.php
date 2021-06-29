<?php
namespace App\Helper;
use GuzzleHttp\Guzzle;
use LaravelShipStation;
use LaravelShipStation\ShipStation;
use Illuminate\Support\Facades\App;
use DB;
use Config;

class shipStationHelper {

    public static function InitializeHelper(){
        $app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
        $testm = "hello";
    }
        
    public static function createOrder($orderData){
        $InitializeHelper = shipStationHelper::InitializeHelper();

        $Shipaddress = new LaravelShipStation\Models\Address();
        $shippingAdd = DB::table('checkout_address')->select('patient_firstname','patient_lastname',
                        'addressline2','addressline1','city','state','zipcode','phone')
                        ->where('order_id',$orderData['order_id'])->get();
        if(count($shippingAdd)>0){
            $Shipaddress->name = $shippingAdd[0]->patient_firstname." ".$shippingAdd[0]->patient_lastname;
            $Shipaddress->street1 = $shippingAdd[0]->addressline2." ".$shippingAdd[0]->addressline2;
            $Shipaddress->city = $shippingAdd[0]->city;
            $Shipaddress->state = $shippingAdd[0]->state;
            $Shipaddress->postalCode = $shippingAdd[0]->zipcode;
            $Shipaddress->country = "US";
            $Shipaddress->phone = $shippingAdd[0]->phone;
        }               
        
        $item = new LaravelShipStation\Models\OrderItem();
        $getCarts = explode(",",$orderData['cart_id']);
        $getitems = array();
        if(count($getCarts)>0){
            foreach($getCarts as $key => $value){
                if(!empty($value) || ($value!=null)){
                    $getproducts = DB::table('carts as c')->join('products as p','c.product_id','=','p.id')
                                ->select('p.name','p.image','p.image_detail','c.product_price as prod_price','c.quantity as prod_qty')
                                ->where('c.id',$value)->get();
                    if(count($getproducts)>0){
                        $arr1 = array('name'=>$getproducts[0]->name,'quantity'=>$getproducts[0]->prod_qty,
                                        'unitPrice'=>strval($getproducts[0]->prod_price),
                                        'warehouseLocation'=>'Nefaire 141 Post Road East Westport, CT 06880',
                                    'imageUrl'=>asset(config('filesystems.products.imageurl').''.$getproducts[0]->image_detail));
                        array_push($getitems, $arr1);
                    }
                }
            }
        }

        $item = $getitems;

	    // $item->lineItemKey = '1';
	    // $item->sku = '580123456';
	    // $item->name = "Awesome sweater.";
	    // $item->quantity = '1';
	    // $item->unitPrice  = '29.99';
	    // $item->warehouseLocation = 'Warehouse A';

        $order = new LaravelShipStation\Models\Order();
	    $order->orderNumber = $orderData['order_id'];
	    $order->orderDate = date("Y-m-d");
	    $order->orderStatus = 'awaiting_shipment';
	    $order->amountPaid = $orderData['total_amount'];
	    $order->taxAmount = $orderData['tax'];
	    $order->shippingAmount = $orderData['shipping_fee'];
	    $order->internalNotes = '';
	    $order->billTo = $Shipaddress;
    	$order->shipTo = $Shipaddress;
    	$order->items[] = $item;

        $newOrder = $shipStation->orders->create($order);

        return (isset($newOrder)) ? $newOrder : 'none';
    }

    public static function getOrderData($orderId){
        
    }

}

?>