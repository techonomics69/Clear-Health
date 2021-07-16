<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $table = "checkout";
    protected $fillable = ['id','user_id', 'order_id', 'cart_id', 'case_id' ,'cart_amount', 'total_amount', 'patient_firstname','patient_lastname','email', 'shipping_fee','shipping_method','shipping_addreess_id','billing_address_id','card_number','card_name','address_type','pharmacy_detail','medication_type','plan_id','plan_quantity','ipladege_id','delivery_date','md_case_id','md_status','telemedicine_fee','handling_fee','tax','gift_code_discount','status','order_detail_id','transaction_id','customer','payment_method','payment_status','transaction_complete_details','strip_refund_object'];

     public function shipping_addreess()
    {
        return $this->belongsTo('App\Models\Checkoutaddress', 'shipping_addreess_id');
    }


     public function billing_address()
    {
        return $this->belongsTo('App\Models\Checkoutaddress', 'billing_address_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Carts', 'cart_id');
    }
}
