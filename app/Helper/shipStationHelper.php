<?php
namespace App\Helper;
use GuzzleHttp\Guzzle;
use LaravelShipStation;
use LaravelShipStation\ShipStation;
use Illuminate\Support\Facades\App;
use DB;
use Config;

class shipStationHelper {
    
        
    public static function createOrder_nonprescribed($orderData){
        $app= App::getFacadeRoot();
        $app->make('LaravelShipStation\ShipStation');
        $shipStation = $app->make('LaravelShipStation\ShipStation');

        $Shipaddress = new LaravelShipStation\Models\Address();
        $shippingAdd = DB::table('checkout_address')->select('patient_firstname','patient_lastname',
                        'addressline2','addressline1','city','state','zipcode','phone')
                        ->where('order_id',$orderData['order_id'])->get();
        if(count($shippingAdd)>0){
            $Shipaddress->name = $shippingAdd[0]->patient_firstname." ".$shippingAdd[0]->patient_lastname;
            $Shipaddress->street1 = $shippingAdd[0]->addressline2;
            $Shipaddress->street2 = $shippingAdd[0]->addressline1;
            $Shipaddress->city = $shippingAdd[0]->city;
            $Shipaddress->state = $shippingAdd[0]->state;
            $Shipaddress->postalCode = $shippingAdd[0]->zipcode;
            $Shipaddress->country = "US";
            $Shipaddress->phone = $shippingAdd[0]->phone;
        }               
        
        
        $getCarts = explode(",",$orderData['cart_id']);
        $getitems = array();
        if(count($getCarts)>0){
            foreach($getCarts as $key => $value){
                    
                if(!empty($value) || ($value!=null)){
                    $getproducts = DB::table('carts as c')->join('products as p','c.product_id','=','p.id')
                                ->select('p.id as productId','p.name','p.image','p.image',
                                'c.product_price as prod_price','c.quantity as prod_qty',
                                'c.status as csatus')
                                ->where('c.id',$value)->get();
                    if(count($getproducts)>0){
                        $arr1 = array('productId'=>$getproducts[0]->productId,'name'=>$getproducts[0]->name,'quantity'=>$getproducts[0]->prod_qty,
                                'unitPrice'=>($getproducts[0]->prod_price!='') ? $getproducts[0]->prod_price : '0',
                                'warehouseLocation'=>'Nefaire 141 Post Road East Westport, CT 06880',
                                'imageUrl'=>asset(config('filesystems.products.imageurl').''.$getproducts[0]->image));
                        array_push($getitems, $arr1);
                        // $item->name = $getproducts[0]->name;
                        // $item->quantity = $getproducts[0]->prod_qty;
                        // $item->unitPrice  = ($getproducts[0]->prod_price!='') ? $getproducts[0]->prod_price : '0';
                        // $item->warehouseLocation = 'Nefaire 141 Post Road East Westport, CT 06880';
                        // $item->imageUrl = asset(config('filesystems.products.imageurl').''.$getproducts[0]->image_detail);
                    }
                }
            }
        }
        // $item = new LaravelShipStation\Models\OrderItem();
        $item = [];
        foreach($getitems as $key => $itm){
            $i = new LaravelShipStation\Models\OrderItem();
            $i->name = $itm['name'];
            $i->quantity = $itm['quantity'];
            $i->unitPrice  = $itm['unitPrice'];
            $i->warehouseLocation = 'Nefaire 141 Post Road East Westport, CT 06880';
            $i->imageUrl = $itm['imageUrl'];
            // $i->productId = $itm['productId'];
            $i->productId = 21;
            $item[] = $i;
        }

        


        

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
    	$order->items = $item;
        $order->advancedOptions = array('storeId'=>'457183');

        $newOrder = $shipStation->orders->create($order);
        $getOrder = json_decode(json_encode($newOrder), true);
        $updateOrder = DB::table('checkout')->where('id',$orderData['checkoutOrderId'])->update(['shipstation_order_id'=>$getOrder['orderId']]);

        return (isset($newOrder)) ? $newOrder : 'none';
    }

    public static function createOrder_prescribed($orderData){
        $accFlag = false;
        $app= App::getFacadeRoot();
        $app->make('LaravelShipStation\ShipStation');
        $shipStation = $app->make('LaravelShipStation\ShipStation');

        $Shipaddress = new LaravelShipStation\Models\Address();
        $shippingAdd = DB::table('checkout_address')->select('patient_firstname','patient_lastname',
                        'addressline2','addressline1','city','state','zipcode','phone')
                        ->where('order_id',$orderData['order_id'])->get();
        if(count($shippingAdd)>0){
            $Shipaddress->name = $shippingAdd[0]->patient_firstname." ".$shippingAdd[0]->patient_lastname;
            $Shipaddress->street1 = $shippingAdd[0]->addressline2;
            $Shipaddress->street2 = $shippingAdd[0]->addressline1;
            $Shipaddress->city = $shippingAdd[0]->city;
            $Shipaddress->state = $shippingAdd[0]->state;
            $Shipaddress->postalCode = $shippingAdd[0]->zipcode;
            $Shipaddress->country = "US";
            $Shipaddress->phone = $shippingAdd[0]->phone;
        }               
        
        // $item = new LaravelShipStation\Models\OrderItem();
        $getCarts = explode(",",$orderData['cart_id']);
        $getitems = array();
        if(count($getCarts)>0){
            foreach($getCarts as $key => $value){
                if(!empty($value) || ($value!=null)){
                    $getproducts = DB::table('carts as c')->join('products as p','c.product_id','=','p.id')
                                ->select('p.id as productId','p.name','p.image','p.image',
                                'c.product_price as prod_price','c.quantity as prod_qty',
                                'c.status as csatus','c.product_id as cart_prod')
                                ->where('c.id',$value)->get();
                    if(count($getproducts)>0){
                        if($getproducts[0]->cart_prod == "33"){
                            $accFlag = true;
                        }else{
                            $arr1 = array('productId'=>$getproducts[0]->productId,'name'=>$getproducts[0]->name,'quantity'=>$getproducts[0]->prod_qty,
                            'unitPrice'=>($getproducts[0]->prod_price!='') ? $getproducts[0]->prod_price : '0',
                            'warehouseLocation'=>'Nefaire 141 Post Road East Westport, CT 06880',
                            'imageUrl'=>asset(config('filesystems.products.imageurl').''.$getproducts[0]->image));
                            array_push($getitems, $arr1);
                            // $item->name = $getproducts[0]->name;
                            // $item->quantity = $getproducts[0]->prod_qty;
                            // $item->unitPrice  = ($getproducts[0]->prod_price!='') ? $getproducts[0]->prod_price : '0';
                            // $item->warehouseLocation = 'Nefaire 141 Post Road East Westport, CT 06880';
                            // $item->imageUrl = asset(config('filesystems.products.imageurl').''.$getproducts[0]->image_detail);
                        }
                    }
                }
            }
        }

        $item = [];
        $ProductTotal = 0;
        foreach($getitems as $key => $itm){
            $i = new LaravelShipStation\Models\OrderItem();
            $i->name = $itm['name'];
            $i->quantity = $itm['quantity'];
            $i->unitPrice  = $itm['unitPrice'];
            $i->warehouseLocation = 'Nefaire 141 Post Road East Westport, CT 06880';
            $i->productId = (int)$itm['productId'];
            $i->imageUrl = $itm['imageUrl'];
            $item[] = $i;
            $ProductTotal += (int)$itm['unitPrice'];
        }


        $order = new LaravelShipStation\Models\Order();
	    $order->orderNumber = $orderData['order_id'];
	    $order->orderDate = date("Y-m-d");
	    $order->orderStatus = 'awaiting_shipment';
	    $order->amountPaid = $ProductTotal;
	    $order->taxAmount = $orderData['tax'];
	    $order->shippingAmount = $orderData['shipping_fee'];
	    $order->internalNotes = '';
	    $order->billTo = $Shipaddress;
    	$order->shipTo = $Shipaddress;
    	$order->items = $item;
        $order->advancedOptions = array('storeId'=>'457183');

        if($accFlag){
            if(count($getitems)>0){
                $newOrder = $shipStation->orders->create($order);
                $getOrder = json_decode(json_encode($newOrder), true);
                $updateOrder = DB::table('checkout')->where('id',$orderData['checkoutOrderId'])->update(['shipstation_order_id'=>$getOrder['orderId']]);            
            }else{
                $newOrder = ''; 
            }            
        }else{
            $newOrder = '';
        }
        

        return (isset($newOrder)) ? $newOrder : 'none';
    }

    public static function getOrderData($orderId){
        $app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
    	$getOrder = $shipStation->orders->get([], $endpoint = $orderId);
    	return $getOrder;
    }

    public static function getRates($request){
    	$app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
    	$shipLocation = array('carrierCode'=>$request['carrierCode'],
    		'fromPostalCode'=>$request['fromPostalCode'],'toCountry'=>$request['toCountry'],
    		'toPostalCode'=>$request['toPostalCode'],'weight'=>$request['weighArr']);
    	$rates = $shipStation->shipments->post($shipLocation, $endpoint = 'getrates');
    	return $rates;
    }

    public static function getCarries(){
    	$app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
    	$carriers = $shipStation->carriers->get([], $endpoint = '');
    	return $carriers;
    }

    public static function getwarehouses(){
    	$app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
    	$getwareHouses = $shipStation->warehouses->get([], $endpoint = '');
    	return $getwareHouses;
    }

    public static function getShipments($orderId){
        $app= App::getFacadeRoot();
    	$app->make('LaravelShipStation\ShipStation');
    	$shipStation = $app->make('LaravelShipStation\ShipStation');
        $shipment = $shipStation->shipments->get(['orderId'=>$orderId], $endpoint = '');
        return $shipment;
    }

}

?>