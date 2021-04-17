<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $table = "checkout";
    protected $fillable = ['id','user_id', 'order_id', 'cart_id', 'cart_amount', 'total_amount', 'patient_firstname','patient_lastname','email','shipping_method','shipping_addreess_id','billing_address_id','card_number','card_name','address_type','pharmacy_detail','medication_type'];



     public function shipping_addreess()
    {
        return $this->belongsTo('App\Models\Checkoutaddress', 'shipping_addreess_id');
    }


     public function billing_address()
    {
        return $this->belongsTo('App\Models\Checkoutaddress', 'billing_address_id');
    }
    
}
